<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// TODO: Uncomment model imports saat backend sudah siap
// use App\Models\Accounting\Jurnal;
// use App\Models\Accounting\BukuBesar;
// use App\Models\Accounting\Akun;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |------------------------------------------------------------------
        | TODO (Backend team): Ganti komentar di bawah dengan query nyata
        |------------------------------------------------------------------
        */

        // $recentJurnals   = Jurnal::latest()->limit(5)->get();
        // $totalDebit      = Jurnal::sum('total_debit');
        // $totalKredit     = Jurnal::sum('total_kredit');

        // $pendapatan      = Akun::pendapatan()->withTotal()->get();
        // $totalPendapatan = $pendapatan->sum('total');
        // $beban           = Akun::beban()->withTotal()->get();
        // $totalBeban      = $beban->sum('total');
        // $labaBersih      = $totalPendapatan - $totalBeban;

        // $aset            = Akun::aset()->withTotal()->get();
        // $totalAset       = $aset->sum('total');
        // $kewajibanModal  = Akun::kewajibanModal()->withTotal()->get();
        // $totalKM         = $kewajibanModal->sum('total');

        // $akunList        = Akun::aktif()->get();
        // $departemenBeban = ...; // dari modul HR/Finance

        return view('accounting.dashboard', [
            // --- Jurnal ---
            'recentJurnals'   => [],          // ganti: $recentJurnals
            'totalDebit'      => 1000000,     // ganti: $totalDebit
            'totalKredit'     => 1000000,     // ganti: $totalKredit

            // --- Laba Rugi ---
            'periodeLabaRugi' => '01-01-2026 s/d 31-01-2026',
            'pendapatan'      => [['nama' => 'Penjualan', 'jumlah' => 50000]],
            'totalPendapatan' => 50000,
            'beban'           => [
                ['nama' => 'Beban Gaji',       'jumlah' => 10000000],
                ['nama' => 'Beban Listrik',     'jumlah' =>  2000000],
                ['nama' => 'Beban Bahan Baku',  'jumlah' => 20000000],
            ],
            'totalBeban'      => 32000000,
            'labaBersih'      => 18000000,

            // --- Neraca ---
            'tanggalNeraca'   => '31-01-2026',
            'aset'            => [
                ['nama' => 'Kas',        'jumlah' => 5000000],
                ['nama' => 'Bank',       'jumlah' => 2000000],
                ['nama' => 'Piutang',    'jumlah' => 1500000],
                ['nama' => 'Persediaan', 'jumlah' => 1500000],
            ],
            'kewajibanModal'  => [
                ['nama' => 'Hutang Usaha', 'jumlah' => 3000000],
                ['nama' => 'Modal',        'jumlah' => 7000000],
            ],
            'totalAset'       => 10000000,
            'totalKM'         => 10000000,

            // --- Rasio ---
            'rasio'           => [
                ['label' => 'Rasio', 'nilai' => 'Rp 1.50',  'color' => 'border-gray-200 text-gray-900'],
                ['label' => 'Rasio', 'nilai' => 'Rp 1.20',  'color' => 'border-gray-200 text-gray-900'],
                ['label' => 'Rasio', 'nilai' => '12.50%',   'color' => 'border-gray-200 text-red-500'],
                ['label' => 'Rasio', 'nilai' => '12.50%',   'color' => 'border-gray-200 text-blue-600'],
            ],

            // --- Akun ---
            'akunList'        => [],          // ganti: $akunList
            'departemenBeban' => [
                ['nama' => 'Production', 'pct' => 60],
                ['nama' => 'Marketing',  'pct' => 40],
                ['nama' => 'Lainnya',    'pct' => 10],
            ],
        ]);
    }
}