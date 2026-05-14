<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Accounting\Akun;
// use Barryvdh\DomPDF\Facade\Pdf;

class NeracaController extends Controller
{
    public function index()
    {
        // TODO: uncomment saat model Akun sudah dibuat oleh backend
        //
        // Aset = akun dengan tipe 'aset'
        // $asetAkun  = Akun::where('tipe_akun', 'aset')->withSaldo()->get();
        // $totalAset = $asetAkun->sum('saldo');
        //
        // Kewajiban = akun dengan tipe 'kewajiban'
        // $kewajibanAkun = Akun::where('tipe_akun', 'kewajiban')->withSaldo()->get();
        //
        // Modal = akun dengan tipe 'modal'
        // $modalAkun = Akun::where('tipe_akun', 'modal')->withSaldo()->get();
        //
        // $totalKM = $kewajibanAkun->sum('saldo') + $modalAkun->sum('saldo');
        //
        // Format untuk view: [ ['nama'=>'...','jumlah'=>...], ... ]
        // $aset      = $asetAkun->map(fn($a) => ['nama' => $a->nama_akun, 'jumlah' => $a->saldo])->toArray();
        // $kewajiban = $kewajibanAkun->map(fn($a) => ['nama' => $a->nama_akun, 'jumlah' => $a->saldo])->toArray();
        // $modal     = $modalAkun->map(fn($a) => ['nama' => $a->nama_akun, 'jumlah' => $a->saldo])->toArray();

        return view('accounting.neraca.index', [
            'tanggal'   => now()->format('d-m-Y'),

            // Ganti array di bawah dengan hasil query saat backend sudah siap
            'aset'      => [
                ['nama' => 'Kas',        'jumlah' => 5000000],
                ['nama' => 'Bank',       'jumlah' => 2000000],
                ['nama' => 'Piutang',    'jumlah' => 1500000],
                ['nama' => 'Persediaan', 'jumlah' => 1500000],
            ],
            'kewajiban' => [
                ['nama' => 'Hutang Usaha', 'jumlah' => 3000000],
            ],
            'modal'     => [
                ['nama' => 'Modal', 'jumlah' => 7000000],
            ],
            'totalAset' => 10000000,
            'totalKM'   => 10000000,
        ]);
    }

    public function exportPdf()
    {
        // TODO:
        // $pdf = Pdf::loadView('accounting.neraca.pdf', [...]);
        // return $pdf->download('laporan-neraca.pdf');

        return back()->with('error', 'Export PDF: jalankan composer require barryvdh/laravel-dompdf terlebih dahulu.');
    }
}