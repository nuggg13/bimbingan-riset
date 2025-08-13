<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Peserta extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'peserta';
    protected $primaryKey = 'id_peserta';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'nomor_wa',
        'instansi',
        'fakultas',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function pendaftaran()
    {
        return $this->hasOne(Pendaftaran::class, 'id_peserta');
    }
}