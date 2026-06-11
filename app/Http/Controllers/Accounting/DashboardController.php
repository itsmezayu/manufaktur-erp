<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use App\Models\Jurnal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $recentJurnals   = Jurnal::latest()->limit(5)->get();
        $totalDebit      = Jurnal::sum('total_debit');
        $totalKredit     = Jurnal::sum('total_kredit');

        $pendapatanAkun  = Akun::pendapatan()->with('jurnalDetails')->get();
        $totalPendapatan = $pendapatanAkun->sum(fn($a) => $a->jurnalDetails->sum('kredit'));
        $pendapatan      = $pendapatanAkun->map(fn($a) => [
            'nama'   => $a->nama_akun,
            'jumlah' => $a->jurnalDetails->sum('kredit'),
        ])->toArray();

        $bebanAkun   = Akun::beban()->with('jurnalDetails')->get();
        $totalBeban  = $bebanAkun->sum(fn($a) => $a->jurnalDetails->sum('debit'));
        $beban       = $bebanAkun->map(fn($a) => [
            'nama'   => $a->nama_akun,
            'jumlah' => $a->jurnalDetails->sum('debit'),
        ])->toArray();

        $labaBersih  = $totalPendapatan - $totalBeban;

        $asetAkun    = Akun::aset()->with('jurnalDetails')->get();
        $totalAset   = $asetAkun->sum(fn($a) => $a->jurnalDetails->sum('debit') - $a->jurnalDetails->sum('kredit'));
        $aset        = $asetAkun->map(fn($a) => [
            'nama'   => $a->nama_akun,
            'jumlah' => $a->jurnalDetails->sum('debit') - $a->jurnalDetails->sum('kredit'),
        ])->toArray();

        $kewajibanAkun  = Akun::kewajiban()->with('jurnalDetails')->get();
        $modalAkun      = Akun::modal()->with('jurnalDetails')->get();
        $kewajibanModal = array_merge(
            $kewajibanAkun->map(fn($a) => ['nama' => $a->nama_akun, 'jumlah' => $a->jurnalDetails->sum('kredit') - $a->jurnalDetails->sum('debit')])->toArray(),
            $modalAkun->map(fn($a) => ['nama' => $a->nama_akun, 'jumlah' => $a->jurnalDetails->sum('kredit') - $a->jurnalDetails->sum('debit')])->toArray()
        );
        $totalKM = collect($kewajibanModal)->sum('jumlah');

        $akunList = Akun::aktif()->get();

        return view('accounting.dashboard', [
            'recentJurnals'   => $recentJurnals,
            'totalDebit'      => $totalDebit,
            'totalKredit'     => $totalKredit,
            'periodeLabaRugi' => now()->startOfMonth()->format('d-m-Y') . ' s/d ' . now()->endOfMonth()->format('d-m-Y'),
            'pendapatan'      => $pendapatan,
            'totalPendapatan' => $totalPendapatan,
            'beban'           => $beban,
            'totalBeban'      => $totalBeban,
            'labaBersih'      => $labaBersih,
            'tanggalNeraca'   => now()->format('d-m-Y'),
            'aset'            => $aset,
            'kewajibanModal'  => $kewajibanModal,
            'totalAset'       => $totalAset,
            'totalKM'         => $totalKM,
            'akunList'        => $akunList,
            'departemenBeban' => $bebanAkun->map(fn($a) => [
    'nama' => $a->nama_akun,
    'pct'  => $totalBeban > 0 ? round(($a->jurnalDetails->sum('debit') / $totalBeban) * 100) : 0,
])->toArray(),

'rasio' => [
    ['label' => 'Current Ratio', 'nilai' => $totalKM > 0 ? number_format($totalAset / $totalKM, 2) : '0', 'color' => 'border-gray-200 text-gray-900'],
    ['label' => 'Debt Ratio', 'nilai' => $totalAset > 0 ? number_format(collect($kewajibanAkun->map(fn($a) => $a->jurnalDetails->sum('kredit')))->sum() / $totalAset * 100, 2).'%' : '0%', 'color' => 'border-gray-200 text-red-500'],
    ['label' => 'Profit Margin', 'nilai' => $totalPendapatan > 0 ? number_format($labaBersih / $totalPendapatan * 100, 2).'%' : '0%', 'color' => 'border-gray-200 text-blue-600'],
],
        ]);
    }
}