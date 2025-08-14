<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Mentor extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'mentor';
    protected $primaryKey = 'id_mentor';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'nomor_wa',
        'keahlian',
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

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_mentor');
    }

    public function pendaftarans()
    {
        return $this->hasManyThrough(Pendaftaran::class, Jadwal::class, 'id_mentor', 'id_pendaftaran', 'id_mentor', 'id_pendaftaran');
    }
}