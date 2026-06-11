<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;

class NeracaController extends Controller
{
    public function index()
    {
        $asetAkun  = Akun::aset()->with('jurnalDetails')->get();
        $totalAset = $asetAkun->sum(fn($a) => $a->jurnalDetails->sum('debit') - $a->jurnalDetails->sum('kredit'));

        $kewajibanAkun = Akun::kewajiban()->with('jurnalDetails')->get();
        $modalAkun     = Akun::modal()->with('jurnalDetails')->get();
        $totalKM       = $kewajibanAkun->sum(fn($a) => $a->jurnalDetails->sum('kredit') - $a->jurnalDetails->sum('debit'))
                       + $modalAkun->sum(fn($a) => $a->jurnalDetails->sum('kredit') - $a->jurnalDetails->sum('debit'));

        $aset      = $asetAkun->map(fn($a) => [
            'nama'   => $a->nama_akun,
            'jumlah' => $a->jurnalDetails->sum('debit') - $a->jurnalDetails->sum('kredit'),
        ])->toArray();

        $kewajiban = $kewajibanAkun->map(fn($a) => [
            'nama'   => $a->nama_akun,
            'jumlah' => $a->jurnalDetails->sum('kredit') - $a->jurnalDetails->sum('debit'),
        ])->toArray();

        $modal = $modalAkun->map(fn($a) => [
            'nama'   => $a->nama_akun,
            'jumlah' => $a->jurnalDetails->sum('kredit') - $a->jurnalDetails->sum('debit'),
        ])->toArray();

        return view('accounting.neraca.index', [
            'tanggal'   => now()->format('d-m-Y'),
            'aset'      => $aset,
            'kewajiban' => $kewajiban,
            'modal'     => $modal,
            'totalAset' => $totalAset,
            'totalKM'   => $totalKM,
        ]);
    }

    public function exportPdf()
    {
        return back()->with('error', 'Export PDF belum tersedia.');
    }
} 