<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employe extends Model
{
    use HasFactory;
    protected $table = 'employe'; // Nama tabel yang digunakan
    protected $primaryKey = 'id_employe'; // Nama primary key
    public $timestamps = false; // Menonaktifkan timestamps (created_at, updated_at)
    protected $fillable = [
        'id_employe',
        'id_company',
        'nama',
        'alamat',
        'id_kel',
        'telepon',
        'id_job',
        'foto',
    ];

}
