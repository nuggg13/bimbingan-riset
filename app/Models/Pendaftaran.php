<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $primaryKey = 'id_pendaftaran';

    public $timestamps = true;

    protected $fillable = [
        'id_peserta',
        'judul_riset',
        'penjelasan',
        'minat_keilmuan',
        'basis_sistem',
        'status',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta', 'id_peserta');
    }

    // Relasi ke Jadwal
    public function jadwal()
    {
        return $this->hasOne(Jadwal::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}


