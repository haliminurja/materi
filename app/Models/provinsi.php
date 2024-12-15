<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class provinsi extends Model
{
    use HasFactory;
    protected $table = 'provinsi'; // Nama tabel yang digunakan
    protected $primaryKey = 'id_prov'; // Nama primary key
    protected $keyType = 'string'; // Tentukan bahwa primary key adalah string
    public $timestamps = false; // Menonaktifkan timestamps (created_at, updated_at)
    protected $fillable = [
        'id_prov',
        'nama',
    ];
}
