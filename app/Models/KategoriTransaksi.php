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

    public function scopeSearch($query, ?string $term)
    {
        if ($term) {
            return $query->where('nama_kategori', 'like', '%' . $term . '%');
        }
        return $query;
    }

    public function scopeJenis($query, ?string $jenis)
    {
        if ($jenis && in_array($jenis, ['pemasukan', 'pengeluaran'])) {
            return $query->where('jenis', $jenis);
        }
        return $query;
    }

    public function scopePemasukan($query)
    {
        return $query->where('jenis', 'pemasukan');
    }

    public function scopePengeluaran($query)
    {
        return $query->where('jenis', 'pengeluaran');
    }
}