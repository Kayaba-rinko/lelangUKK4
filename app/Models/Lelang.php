<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lelang extends Model
{
    use HasFactory;
    protected $table = 'lelangs';
    protected $guarded = [];
    protected $primaryKey = 'id_lelang';
    protected $fillable = [
        'id_barang',
        'id_petugas',
        'id_masyarakat',
        'tgl_lelang',
        'harga_akhir',
        'status',
    ];
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }
    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class, 'id_masyarakat', 'id_masyarakat');
    }
    public function historyLelangs()
    {
        return $this->hasMany(HistoryLelang::class, 'id_lelang', 'id_lelang');
    }
    public function pemenang()
    {
        return $this->belongsTo(Masyarakat::class, 'id_masyarakat');
    }
    public function history()
    {
        return $this->hasMany(HistoryLelang::class, 'id_lelang');
    }
}
