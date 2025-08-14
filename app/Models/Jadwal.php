<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'id_pendaftaran',
        'id_mentor',
        'tanggal_mulai',
        'tanggal_akhir',
        'jam_mulai',
        'jam_akhir',
        'hari',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_akhir' => 'datetime:H:i',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran');
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'id_mentor');
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'scheduled' => 'Terjadwal',
            'ongoing' => 'Sedang Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];

        return $labels[$this->status] ?? 'Status Tidak Diketahui';
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'scheduled' => 'blue',
            'ongoing' => 'green',
            'completed' => 'gray',
            'cancelled' => 'red'
        ];

        return $colors[$this->status] ?? 'gray';
    }

    public function getFormattedDateTimeAttribute()
    {
        $startDate = $this->tanggal_mulai->format('d M Y');
        $endDate = $this->tanggal_akhir->format('d M Y');
        $startTime = Carbon::parse($this->jam_mulai)->format('H:i');
        $endTime = Carbon::parse($this->jam_akhir)->format('H:i');

        if ($startDate === $endDate) {
            return "{$startDate}, {$startTime} - {$endTime}";
        } else {
            return "{$startDate} {$startTime} - {$endDate} {$endTime}";
        }
    }

    public function getHariArrayAttribute()
    {
        if (!$this->hari) {
            return [];
        }
        return explode(',', $this->hari);
    }

    public function getFormattedHariAttribute()
    {
        $hariMap = [
            'senin' => 'Senin',
            'selasa' => 'Selasa', 
            'rabu' => 'Rabu',
            'kamis' => 'Kamis',
            'jumat' => 'Jumat',
            'sabtu' => 'Sabtu',
            'minggu' => 'Minggu'
        ];

        $hariArray = $this->hari_array;
        $formattedHari = array_map(function($hari) use ($hariMap) {
            return $hariMap[strtolower(trim($hari))] ?? ucfirst(trim($hari));
        }, $hariArray);

        if (count($formattedHari) <= 2) {
            return implode(' dan ', $formattedHari);
        } else {
            $last = array_pop($formattedHari);
            return implode(', ', $formattedHari) . ', dan ' . $last;
        }
    }

    public function getScheduleDescriptionAttribute()
    {
        $startTime = Carbon::parse($this->jam_mulai)->format('H:i');
        $endTime = Carbon::parse($this->jam_akhir)->format('H:i');
        
        if ($this->hari) {
            return "Setiap {$this->formatted_hari}, {$startTime} - {$endTime}";
        } else {
            return $this->formatted_date_time;
        }
    }
}