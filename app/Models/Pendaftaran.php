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
        // Kolom "berbasis" tidak pasti penamaannya di DB, jadi tidak dipaksakan di fillable
        'status',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta', 'id_peserta');
    }
}


