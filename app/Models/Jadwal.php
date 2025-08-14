<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $primaryKey = 'id_jadwal';

    public $timestamps = true;

    protected $fillable = [
        'id_pendaftaran',
        'id_mentor',
        'tanggal_mulai',
        'tanggal_akhir',
        'jam_mulai',
        'jam_akhir',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_akhir' => 'datetime:H:i',
    ];

    // Relasi ke Pendaftaran
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    // Relasi ke Mentor
    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'id_mentor', 'id_mentor');
    }
}