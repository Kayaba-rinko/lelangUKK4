<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Masyarakat extends Authenticatable 
{
    use HasFactory;

    protected $table = 'masyarakat';
    protected $guarded = [];
    protected $primaryKey = 'id_masyarakat';
    protected $fillable = [
        'name',
        'username',
        'password',
        'alamat',
        'status',
        'telp',
    ];
    public function lelangs()
    {
        return $this->hasMany(Lelang::class, 'id_masyarakat', 'id_masyarakat');
    }
    public function historyLelangs()
    {
        return $this->hasMany(HistoryLelang::class, 'id_masyarakat', 'id_masyarakat');
    }
}
