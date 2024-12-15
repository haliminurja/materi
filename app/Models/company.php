<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;

class company extends Authenticable
{
    use Notifiable;
    protected $guard = 'company'; // nama autentikasi
    protected $table = 'company'; // Nama tabel yang digunakan
    protected $primaryKey = 'id_company'; // Nama primary key
    public $timestamps = false; // Menonaktifkan timestamps (created_at, updated_at)
    protected $fillable = [
        'id_company',
        'company',
        'email',
        'telepon',
        'username',
        'password',
    ];
}
