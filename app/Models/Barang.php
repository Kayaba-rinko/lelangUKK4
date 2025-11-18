<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';
    protected $guarded = [];
    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'nama_barang',
        'tgl_masuk',
        'harga_awal',
        'deskripsi_barang',
        'gambar',
    ];
    protected $casts = [
        'tgl_masuk' => 'date',
    ];

    public function lelangs()
    {
        return $this->hasMany(Lelang::class, 'id_barang', 'id_barang');
    }
    public function historyLelangs()
    {
        return $this->hasMany(HistoryLelang::class, 'id_barang', 'id_barang');
    }
    
}
