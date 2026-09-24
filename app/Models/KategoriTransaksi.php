<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriTransaksi extends Model
{
    protected $table = 'kategori_transaksi';

    protected $fillable = [
        'nama_kategori',
        'jenis',
    ];

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'kategori_id');
    }
}