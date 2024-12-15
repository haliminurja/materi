<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class job extends Model
{
    use HasFactory;
    protected $table = 'job'; // Nama tabel yang digunakan
    protected $primaryKey = 'id_job'; // Nama primary key
    public $timestamps = false; // Menonaktifkan timestamps (created_at, updated_at)
    protected $fillable = [
        'id_job',
        'nama',
    ];

}
