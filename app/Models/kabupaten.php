<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kabupaten extends Model
{
    use HasFactory;
    protected $table = 'kabupaten'; // Nama tabel yang digunakan
    protected $primaryKey = 'id_kab'; // Nama primary key
    protected $keyType = 'string'; // Tentukan bahwa primary key adalah string
    public $timestamps = false; // Menonaktifkan timestamps (created_at, updated_at)
    protected $fillable = [
        'id_kab ',
        'id_prov',
        'nama',
    ];
}
