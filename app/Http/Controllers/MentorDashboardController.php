<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\Pendaftaran;
use App\Models\Peserta;

class MentorDashboardController extends Controller
{
    public function dashboard()
    {
        $mentor = Auth::guard('mentor')->user();
        
        // Get all schedules for this mentor with related data
        $jadwals = Jadwal::with(['pendaftaran.peserta'])
            ->where('id_mentor', $mentor->id_mentor)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get participants being mentored by this mentor
        $participants = collect();
        
        foreach ($jadwals as $jadwal) {
            if ($jadwal->pendaftaran && $jadwal->pendaftaran->peserta) {
                $participant = $jadwal->pendaftaran->peserta;
                $participant->pendaftaran = $jadwal->pendaftaran;
                $participant->jadwal = $jadwal;
                $participants->push($participant);
            }
        }

        // Remove duplicates based on peserta id
        $participants = $participants->unique('id_peserta');

        // Statistics
        $totalParticipants = $participants->count();
        $activeSchedules = $jadwals->whereIn('status', ['scheduled', 'ongoing'])->count();
        $completedSchedules = $jadwals->where('status', 'completed')->count();
        $pendingRegistrations = $jadwals->filter(function($jadwal) {
            return $jadwal->pendaftaran && $jadwal->pendaftaran->status == 'pending';
        })->count();

        return view('mentor.dashboard', compact(
            'mentor',
            'participants',
            'jadwals',
            'totalParticipants',
            'activeSchedules',
            'completedSchedules',
            'pendingRegistrations'
        ));
    }

    public function participants()
    {
        $mentor = Auth::guard('mentor')->user();
        
        // Get all participants being mentored by this mentor
        $participants = Peserta::whereHas('pendaftaran.jadwals', function($query) use ($mentor) {
            $query->where('id_mentor', $mentor->id_mentor);
        })
        ->with(['pendaftaran.jadwals' => function($query) use ($mentor) {
            $query->where('id_mentor', $mentor->id_mentor);
        }])
        ->get();

        return view('mentor.participants.index', compact('participants', 'mentor'));
    }

    public function participantDetail($id)
    {
        $mentor = Auth::guard('mentor')->user();
        
        // Get participant with their registration and schedule details
        $participant = Peserta::with(['pendaftaran.jadwals' => function($query) use ($mentor) {
            $query->where('id_mentor', $mentor->id_mentor);
        }])
        ->findOrFail($id);

        // Verify this participant is being mentored by the current mentor
        $hasAccess = $participant->pendaftaran && 
                    $participant->pendaftaran->jadwals->where('id_mentor', $mentor->id_mentor)->count() > 0;

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke peserta ini.');
        }

        return view('mentor.participants.detail', compact('participant', 'mentor'));
    }

    public function schedules()
    {
        $mentor = Auth::guard('mentor')->user();
        
        $jadwals = Jadwal::with(['pendaftaran.peserta'])
            ->where('id_mentor', $mentor->id_mentor)
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('mentor.schedules.index', compact('jadwals', 'mentor'));
    }
}