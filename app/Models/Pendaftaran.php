<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';

    protected $fillable = [
        'id_peserta',
        'judul_riset',
        'penjelasan',
        'minat_keilmuan',
        'basis_sistem',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Review',
            'review' => 'Sedang Direview',
            'konsultasi' => 'Perlu Konsultasi',
            'ditolak' => 'Ditolak',
            'diterima' => 'Diterima'
        ];

        return $labels[$this->status] ?? 'Status Tidak Diketahui';
    }

    public function getStatusMessageAttribute()
    {
        $messages = [
            'pending' => 'Pendaftaran Anda sedang dalam proses review. Mohon tunggu konfirmasi dari tim kami.',
            'review' => 'Pendaftaran Anda sedang direview oleh tim kami. Kami akan segera memberikan update.',
            'konsultasi' => 'Pendaftaran Anda memerlukan konsultasi lebih lanjut. Tim kami akan menghubungi Anda segera.',
            'ditolak' => 'Maaf, pendaftaran Anda tidak dapat diterima saat ini. Silakan hubungi admin untuk informasi lebih lanjut.',
            'diterima' => 'Selamat! Pendaftaran Anda telah diterima. Selamat datang di program bimbingan riset.'
        ];

        return $messages[$this->status] ?? 'Status tidak diketahui.';
    }
}