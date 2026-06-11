<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $fillable = ['tanggal', 'keterangan', 'total_debit', 'total_kredit', 'status'];

    protected $casts = ['tanggal' => 'date'];

    public function details()
    {
        return $this->hasMany(JurnalDetail::class);
    }

    public function getTotalAttribute()
    {
        return $this->total_debit;
    }
}