<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{

protected $table = 'akuns';

    protected $fillable = ['kode_akun', 'nama_akun', 'tipe_akun', 'tipe_parent', 'status'];

    public function jurnalDetails()
    {
        return $this->hasMany(JurnalDetail::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    public function scopePendapatan($query)
    {
        return $query->where('tipe_akun', 'pendapatan');
    }

    public function scopeBeban($query)
    {
        return $query->where('tipe_akun', 'beban');
    }

    public function scopeAset($query)
    {
        return $query->where('tipe_akun', 'aset');
    }

    public function scopeKewajiban($query)
    {
        return $query->where('tipe_akun', 'kewajiban');
    }

    public function scopeModal($query)
    {
        return $query->where('tipe_akun', 'modal');
    }
}