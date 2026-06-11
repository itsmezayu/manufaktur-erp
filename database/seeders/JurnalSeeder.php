<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurnal;
use App\Models\JurnalDetail;
use App\Models\Akun;

class JurnalSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil akun yang dibutuhkan
        $kas          = Akun::where('kode_akun', '1-1001')->first();
        $bank         = Akun::where('kode_akun', '1-1002')->first();
        $piutang      = Akun::where('kode_akun', '1-1003')->first();
        $persediaan   = Akun::where('kode_akun', '1-1004')->first();
        $hutangUsaha  = Akun::where('kode_akun', '2-1001')->first();
        $hutangBank   = Akun::where('kode_akun', '2-1002')->first();
        $modal        = Akun::where('kode_akun', '3-1001')->first();
        $labaditahan  = Akun::where('kode_akun', '3-1002')->first();
        $penjualan    = Akun::where('kode_akun', '4-1001')->first();
        $bebanGaji    = Akun::where('kode_akun', '5-1001')->first();
        $bebanListrik = Akun::where('kode_akun', '5-1002')->first();
        $bebanBahan   = Akun::where('kode_akun', '5-1003')->first();

        // Jurnal 1: Setoran modal awal
        $j1 = Jurnal::create([
            'tanggal'      => now()->startOfMonth(),
            'keterangan'   => 'Setoran modal awal',
            'total_debit'  => 20000000,
            'total_kredit' => 20000000,
            'status'       => 'posted',
        ]);
        JurnalDetail::insert([
            ['jurnal_id' => $j1->id, 'akun_id' => $kas->id,   'debit' => 20000000, 'kredit' => 0,        'keterangan' => 'Kas masuk', 'created_at' => now(), 'updated_at' => now()],
            ['jurnal_id' => $j1->id, 'akun_id' => $modal->id, 'debit' => 0,        'kredit' => 20000000, 'keterangan' => 'Modal',     'created_at' => now(), 'updated_at' => now()],
        ]);

        // Jurnal 2: Penjualan tunai
        $j2 = Jurnal::create([
            'tanggal'      => now()->startOfMonth()->addDays(5),
            'keterangan'   => 'Penjualan produk',
            'total_debit'  => 50000000,
            'total_kredit' => 50000000,
            'status'       => 'posted',
        ]);
        JurnalDetail::insert([
            ['jurnal_id' => $j2->id, 'akun_id' => $kas->id,       'debit' => 50000000, 'kredit' => 0,        'keterangan' => 'Kas penjualan', 'created_at' => now(), 'updated_at' => now()],
            ['jurnal_id' => $j2->id, 'akun_id' => $penjualan->id, 'debit' => 0,        'kredit' => 50000000, 'keterangan' => 'Pendapatan',     'created_at' => now(), 'updated_at' => now()],
        ]);

        // Jurnal 3: Beban gaji
        $j3 = Jurnal::create([
            'tanggal'      => now()->startOfMonth()->addDays(10),
            'keterangan'   => 'Pembayaran gaji karyawan',
            'total_debit'  => 10000000,
            'total_kredit' => 10000000,
            'status'       => 'posted',
        ]);
        JurnalDetail::insert([
            ['jurnal_id' => $j3->id, 'akun_id' => $bebanGaji->id, 'debit' => 10000000, 'kredit' => 0,        'keterangan' => 'Beban gaji', 'created_at' => now(), 'updated_at' => now()],
            ['jurnal_id' => $j3->id, 'akun_id' => $kas->id,       'debit' => 0,        'kredit' => 10000000, 'keterangan' => 'Kas keluar', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Jurnal 4: Beban listrik
        $j4 = Jurnal::create([
            'tanggal'      => now()->startOfMonth()->addDays(15),
            'keterangan'   => 'Pembayaran listrik',
            'total_debit'  => 2000000,
            'total_kredit' => 2000000,
            'status'       => 'posted',
        ]);
        JurnalDetail::insert([
            ['jurnal_id' => $j4->id, 'akun_id' => $bebanListrik->id, 'debit' => 2000000, 'kredit' => 0,       'keterangan' => 'Beban listrik', 'created_at' => now(), 'updated_at' => now()],
            ['jurnal_id' => $j4->id, 'akun_id' => $kas->id,          'debit' => 0,       'kredit' => 2000000, 'keterangan' => 'Kas keluar',    'created_at' => now(), 'updated_at' => now()],
        ]);

        // Jurnal 5: Beban bahan baku
        $j5 = Jurnal::create([
            'tanggal'      => now()->startOfMonth()->addDays(20),
            'keterangan'   => 'Pembelian bahan baku',
            'total_debit'  => 20000000,
            'total_kredit' => 20000000,
            'status'       => 'posted',
        ]);
        JurnalDetail::insert([
            ['jurnal_id' => $j5->id, 'akun_id' => $bebanBahan->id, 'debit' => 20000000, 'kredit' => 0,        'keterangan' => 'Beban bahan baku', 'created_at' => now(), 'updated_at' => now()],
            ['jurnal_id' => $j5->id, 'akun_id' => $kas->id,        'debit' => 0,        'kredit' => 20000000, 'keterangan' => 'Kas keluar',       'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}