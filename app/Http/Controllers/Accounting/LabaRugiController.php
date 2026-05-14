<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Accounting\Akun;
// use Barryvdh\DomPDF\Facade\Pdf;

class LabaRugiController extends Controller
{
    public function index(Request $request)
    {
        // TODO: uncomment saat model Akun sudah dibuat
        // Pendapatan = akun dengan tipe 'pendapatan'
        // $pendapatanAkun  = Akun::where('tipe_akun','pendapatan')->withJurnalTotal()->get();
        // $totalPendapatan = $pendapatanAkun->sum('total');

        // Beban = akun dengan tipe 'beban'
        // $bebanAkun   = Akun::where('tipe_akun','beban')->withJurnalTotal()->get();
        // $totalBeban  = $bebanAkun->sum('total');

        // $labaBersih  = $totalPendapatan - $totalBeban;

        // Format untuk view: [ ['nama'=>'...','jumlah'=>...], ... ]
        // $pendapatan = $pendapatanAkun->map(fn($a) => ['nama'=>$a->nama_akun,'jumlah'=>$a->total])->toArray();
        // $beban      = $bebanAkun->map(fn($a) => ['nama'=>$a->nama_akun,'jumlah'=>$a->total])->toArray();

        return view('accounting.laba-rugi.index', [
            'periodeAwal'     => now()->startOfMonth()->format('d-m-Y'),
            'periodeAkhir'    => now()->endOfMonth()->format('d-m-Y'),

            // Ganti array di bawah dengan variabel dari query di atas
            'pendapatan'      => [
                ['nama' => 'Penjualan', 'jumlah' => 50000],
            ],
            'totalPendapatan' => 50000,

            'beban'           => [
                ['nama' => 'Beban Gaji',      'jumlah' => 10000000],
                ['nama' => 'Beban Listrik',    'jumlah' =>  2000000],
                ['nama' => 'Beban Bahan Baku', 'jumlah' => 20000000],
            ],
            'totalBeban'      => 32000000,
            'labaBersih'      => 18000000,
        ]);
    }

    public function exportPdf()
    {
        // TODO:
        // $pdf = Pdf::loadView('accounting.laba-rugi.pdf', $this->getData());
        // return $pdf->download('laporan-laba-rugi.pdf');

        return back()->with('error', 'Export PDF: jalankan composer require barryvdh/laravel-dompdf terlebih dahulu.');
    }
}