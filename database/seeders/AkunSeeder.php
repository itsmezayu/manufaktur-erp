<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Akun;

class AkunSeeder extends Seeder
{
    public function run(): void
    {
        $akuns = [
            // Aset
            ['kode_akun' => '1-1001', 'nama_akun' => 'Kas',              'tipe_akun' => 'aset',       'status' => 'Aktif'],
            ['kode_akun' => '1-1002', 'nama_akun' => 'Bank',             'tipe_akun' => 'aset',       'status' => 'Aktif'],
            ['kode_akun' => '1-1003', 'nama_akun' => 'Piutang Usaha',    'tipe_akun' => 'aset',       'status' => 'Aktif'],
            ['kode_akun' => '1-1004', 'nama_akun' => 'Persediaan',       'tipe_akun' => 'aset',       'status' => 'Aktif'],
            // Kewajiban
            ['kode_akun' => '2-1001', 'nama_akun' => 'Hutang Usaha',     'tipe_akun' => 'kewajiban',  'status' => 'Aktif'],
            ['kode_akun' => '2-1002', 'nama_akun' => 'Hutang Bank',      'tipe_akun' => 'kewajiban',  'status' => 'Aktif'],
            // Modal
            ['kode_akun' => '3-1001', 'nama_akun' => 'Modal Pemilik',    'tipe_akun' => 'modal',      'status' => 'Aktif'],
            ['kode_akun' => '3-1002', 'nama_akun' => 'Laba Ditahan',     'tipe_akun' => 'modal',      'status' => 'Aktif'],
            // Pendapatan
            ['kode_akun' => '4-1001', 'nama_akun' => 'Penjualan',        'tipe_akun' => 'pendapatan', 'status' => 'Aktif'],
            ['kode_akun' => '4-1002', 'nama_akun' => 'Pendapatan Lain',  'tipe_akun' => 'pendapatan', 'status' => 'Aktif'],
            // Beban
            ['kode_akun' => '5-1001', 'nama_akun' => 'Beban Gaji',       'tipe_akun' => 'beban',      'status' => 'Aktif'],
            ['kode_akun' => '5-1002', 'nama_akun' => 'Beban Listrik',    'tipe_akun' => 'beban',      'status' => 'Aktif'],
            ['kode_akun' => '5-1003', 'nama_akun' => 'Beban Bahan Baku', 'tipe_akun' => 'beban',      'status' => 'Aktif'],
        ];

        foreach ($akuns as $akun) {
            Akun::create($akun);
        }
    }
}