<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LabaRugiController extends Controller
{
    public function index(Request $request)
    {
        $pendapatanAkun  = Akun::pendapatan()->with('jurnalDetails')->get();
        $totalPendapatan = $pendapatanAkun->sum(fn($a) => $a->jurnalDetails->sum('kredit'));

        $bebanAkun   = Akun::beban()->with('jurnalDetails')->get();
        $totalBeban  = $bebanAkun->sum(fn($a) => $a->jurnalDetails->sum('debit'));

        $labaBersih  = $totalPendapatan - $totalBeban;

        $pendapatan = $pendapatanAkun->map(fn($a) => [
            'nama'   => $a->nama_akun,
            'jumlah' => $a->jurnalDetails->sum('kredit'),
        ])->toArray();

        $beban = $bebanAkun->map(fn($a) => [
            'nama'   => $a->nama_akun,
            'jumlah' => $a->jurnalDetails->sum('debit'),
        ])->toArray();

        return view('accounting.laba-rugi.index', [
            'periodeAwal'     => now()->startOfMonth()->format('d-m-Y'),
            'periodeAkhir'    => now()->endOfMonth()->format('d-m-Y'),
            'pendapatan'      => $pendapatan,
            'totalPendapatan' => $totalPendapatan,
            'beban'           => $beban,
            'totalBeban'      => $totalBeban,
            'labaBersih'      => $labaBersih,
        ]);
    }

    public function exportPdf()
    {
        // Tarik data dengan logika yang sama persis seperti pada halaman index
        $pendapatanAkun  = Akun::pendapatan()->with('jurnalDetails')->get();
        $totalPendapatan = $pendapatanAkun->sum(fn($a) => $a->jurnalDetails->sum('kredit'));

        $bebanAkun   = Akun::beban()->with('jurnalDetails')->get();
        $totalBeban  = $bebanAkun->sum(fn($a) => $a->jurnalDetails->sum('debit'));

        $labaBersih  = $totalPendapatan - $totalBeban;

        $pendapatan = $pendapatanAkun->map(fn($a) => [
            'nama'   => $a->nama_akun,
            'jumlah' => $a->jurnalDetails->sum('kredit'),
        ])->toArray();

        $beban = $bebanAkun->map(fn($a) => [
            'nama'   => $a->nama_akun,
            'jumlah' => $a->jurnalDetails->sum('debit'),
        ])->toArray();

        // Render data ke template PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('accounting.laba-rugi.pdf', [
            'periodeAwal'     => now()->startOfMonth()->format('d-m-Y'),
            'periodeAkhir'    => now()->endOfMonth()->format('d-m-Y'),
            'pendapatan'      => $pendapatan,
            'totalPendapatan' => $totalPendapatan,
            'beban'           => $beban,
            'totalBeban'      => $totalBeban,
            'labaBersih'      => $labaBersih,
        ]);

        // Download otomatis file laporan laba rugi
        return $pdf->download('laporan-laba-rugi-' . now()->format('m-Y') . '.pdf');
    }
}