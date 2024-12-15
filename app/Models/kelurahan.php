<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelurahan extends Model
{
    use HasFactory;
    protected $table = 'kelurahan'; // Nama tabel yang digunakan
    protected $primaryKey = 'id_kel'; // Nama primary key
    protected $keyType = 'string'; // Tentukan bahwa primary key adalah string
    public $timestamps = false; // Menonaktifkan timestamps (created_at, updated_at)
    protected $fillable = [
        'id_kel ',
        'id_kec',
        'nama',
    ];
}
