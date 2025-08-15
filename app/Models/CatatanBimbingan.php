<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanBimbingan extends Model
{
    use HasFactory;

    protected $table = 'catatan_bimbingan';
    protected $primaryKey = 'id_catatan';

    protected $fillable = [
        'id_peserta',
        'tanggal_bimbingan',
        'hasil_bimbingan',
        'tugas_perbaikan',
        'catatan_tambahan',
        'status',
    ];

    protected $casts = [
        'tanggal_bimbingan' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }

    public function updateProgress()
    {
        return $this->hasMany(UpdateProgress::class, 'id_catatan');
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'draft' => 'Draft',
            'published' => 'Dipublikasi',
            'reviewed' => 'Direview',
            'completed' => 'Selesai'
        ];

        return $labels[$this->status] ?? 'Status Tidak Diketahui';
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'draft' => 'gray',
            'published' => 'blue',
            'reviewed' => 'yellow',
            'completed' => 'green'
        ];

        return $colors[$this->status] ?? 'gray';
    }

    public function getLatestProgressAttribute()
    {
        return $this->updateProgress()->latest('tanggal_update')->first();
    }

    public function getTotalProgressPercentageAttribute()
    {
        $latestProgress = $this->latest_progress;
        return $latestProgress ? $latestProgress->persentase : 0;
    }
}