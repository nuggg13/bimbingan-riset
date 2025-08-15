<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateProgress extends Model
{
    use HasFactory;

    protected $table = 'update_progress';
    protected $primaryKey = 'id_progress';

    public $timestamps = true;
    const UPDATED_AT = null; // Table only has created_at

    protected $fillable = [
        'id_catatan',
        'tanggal_update',
        'deskripsi_progress',
        'persentase',
    ];

    protected $casts = [
        'tanggal_update' => 'date',
        'persentase' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function catatanBimbingan()
    {
        return $this->belongsTo(CatatanBimbingan::class, 'id_catatan');
    }

    public function getFormattedPersentaseAttribute()
    {
        return number_format($this->persentase, 1) . '%';
    }

    public function getProgressColorAttribute()
    {
        if ($this->persentase >= 80) {
            return 'green';
        } elseif ($this->persentase >= 60) {
            return 'blue';
        } elseif ($this->persentase >= 40) {
            return 'yellow';
        } elseif ($this->persentase >= 20) {
            return 'orange';
        } else {
            return 'red';
        }
    }

    public function getProgressStatusAttribute()
    {
        if ($this->persentase >= 100) {
            return 'Selesai';
        } elseif ($this->persentase >= 80) {
            return 'Hampir Selesai';
        } elseif ($this->persentase >= 60) {
            return 'Dalam Progres';
        } elseif ($this->persentase >= 40) {
            return 'Setengah Jalan';
        } elseif ($this->persentase >= 20) {
            return 'Baru Dimulai';
        } else {
            return 'Belum Dimulai';
        }
    }
}