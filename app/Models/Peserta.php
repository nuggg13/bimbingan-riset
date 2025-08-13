<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

    protected $primaryKey = 'id_peserta';

    public $timestamps = true;

    protected $fillable = [
        'nama',
        'fakultas',
        'instansi',
        // tambahkan kolom lain sesuai kebutuhan
    ];

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'id_peserta', 'id_peserta');
    }
}
