@extends('mentor.layout')

@section('title', 'Jadwal Bimbingan')

@section('content')
<div class="space-y-6">
    <!-- Header + Search -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Jadwal Bimbingan</h1>
                <p class="text-gray-600 mt-1">Kalender bimbingan yang rapi dan interaktif</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                <div class="relative">
                    <input id="scheduleSearch" type="text" placeholder="Cari peserta, judul riset, status..." class="w-full sm:w-80 pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" />
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Total Jadwal</p>
                    <p class="text-2xl font-bold text-green-600">{{ $jadwals->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <!-- Calendar Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            <div class="flex items-center gap-2">
                <button id="prevMonth" class="px-3 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200"><i class="fas fa-chevron-left"></i></button>
                <div id="currentMonth" class="text-lg font-semibold text-gray-800"></div>
                <button id="nextMonth" class="px-3 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Terjadwal</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Berlangsung</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Selesai</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Dibatalkan</span>
            </div>
        </div>

        <div class="grid grid-cols-7 gap-2 text-xs font-medium text-gray-500 mb-2">
            <div class="text-center">Sen</div>
            <div class="text-center">Sel</div>
            <div class="text-center">Rab</div>
            <div class="text-center">Kam</div>
            <div class="text-center">Jum</div>
            <div class="text-center">Sab</div>
            <div class="text-center">Min</div>
        </div>

        <div id="calendarGrid" class="grid grid-cols-7 gap-2"></div>
    </div>

    <!-- Selected Day Panel -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800"><i class="fas fa-list text-green-600 mr-2"></i> Jadwal Tanggal <span id="selectedDateLabel">-</span></h2>
                <span id="dayCount" class="text-sm text-gray-500"></span>
            </div>
        </div>
        <div id="selectedDayList" class="p-6">
            <div class="text-center py-8 text-gray-500">Pilih tanggal pada kalender untuk melihat detail jadwal.</div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Prepare events data from backend
const events = @json($jadwals->map(function($j){
    return [
        'id' => $j->id_jadwal,
        'participant' => $j->pendaftaran->peserta->nama,
        'participantId' => $j->pendaftaran->peserta->id_peserta,
        'judul' => $j->pendaftaran->judul_riset,
        'start' => ($j->tanggal_mulai ? $j->tanggal_mulai->toDateString() : null),
        'end' => ($j->tanggal_akhir ? $j->tanggal_akhir->toDateString() : null),
        'startTime' => ($j->jam_mulai ? \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') : null),
        'endTime' => ($j->jam_akhir ? \Carbon\Carbon::parse($j->jam_akhir)->format('H:i') : null),
        'status' => $j->status,
        'statusLabel' => $j->status_label,
        'statusColor' => $j->status_color,
        'hari' => ($j->hari ? $j->formatted_hari : null),
        'wa' => ($j->pendaftaran->peserta->nomor_wa ? preg_replace('/[^0-9]/', '', $j->pendaftaran->peserta->nomor_wa) : null),
    ];
}));

// Calendar state
let current = new Date();
let selectedDate = null;

const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

const currentMonthEl = document.getElementById('currentMonth');
const calendarGrid = document.getElementById('calendarGrid');
const selectedDateLabel = document.getElementById('selectedDateLabel');
const selectedDayList = document.getElementById('selectedDayList');
const dayCount = document.getElementById('dayCount');
const searchInput = document.getElementById('scheduleSearch');

function formatDateKey(d){
    const y = d.getFullYear();
    const m = String(d.getMonth()+1).padStart(2,'0');
    const day = String(d.getDate()).padStart(2,'0');
    return `${y}-${m}-${day}`;
}

function dateInRange(dateStr, startStr, endStr){
    if(!startStr || !endStr) return false;
    return dateStr >= startStr && dateStr <= endStr;
}

function renderCalendar(){
    const year = current.getFullYear();
    const month = current.getMonth();
    currentMonthEl.textContent = `${monthNames[month]} ${year}`;

    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);

    // Determine leading blanks (Mon=0..Sun=6 for our grid)
    let startOffset = firstDay.getDay(); // 0=Sun..6=Sat
    // Convert to Monday-first
    startOffset = (startOffset === 0) ? 6 : startOffset - 1;

    calendarGrid.innerHTML = '';

    // Previous month placeholders
    for(let i=0; i<startOffset; i++){
        const cell = document.createElement('div');
        cell.className = 'border rounded-lg p-2 h-28 bg-gray-50';
        calendarGrid.appendChild(cell);
    }

    const q = (searchInput.value || '').toLowerCase();

    for(let day=1; day<=lastDay.getDate(); day++){
        const d = new Date(year, month, day);
        const key = formatDateKey(d);

        const cell = document.createElement('div');
        cell.className = 'border rounded-lg p-2 h-28 hover:shadow transition cursor-pointer relative';

        // Day label
        const label = document.createElement('div');
        label.className = 'text-xs font-semibold text-gray-600';
        label.textContent = day;
        cell.appendChild(label);

        // Events preview chips
        const dayEvents = events.filter(e => dateInRange(key, e.start, e.end));
        const filtered = dayEvents.filter(e =>
            e.participant.toLowerCase().includes(q) ||
            (e.judul || '').toLowerCase().includes(q) ||
            (e.statusLabel || '').toLowerCase().includes(q)
        );

        const container = document.createElement('div');
        container.className = 'mt-2 space-y-1 overflow-y-auto max-h-20 pr-1';

        filtered.slice(0,3).forEach(e => {
            const chip = document.createElement('div');
            const colorMap = {
                scheduled: 'bg-blue-100 text-blue-800',
                ongoing: 'bg-green-100 text-green-800',
                completed: 'bg-gray-100 text-gray-800',
                cancelled: 'bg-red-100 text-red-800',
            };
            chip.className = `text-xs ${colorMap[e.status] || 'bg-gray-100 text-gray-800'} px-2 py-0.5 rounded-full truncate`;
            chip.title = `${e.participant} — ${e.judul || ''}`;
            chip.textContent = `${e.participant}`;
            container.appendChild(chip);
        });

        if(filtered.length > 3){
            const more = document.createElement('div');
            more.className = 'text-xs text-gray-500';
            more.textContent = `+${filtered.length - 3} lagi`;
            container.appendChild(more);
        }

        cell.appendChild(container);

        // Today highlight
        const today = new Date();
        if(today.toDateString() === d.toDateString()){
            const dot = document.createElement('div');
            dot.className = 'w-1.5 h-1.5 bg-green-500 rounded-full absolute top-2 right-2';
            cell.appendChild(dot);
        }

        cell.addEventListener('click', () => {
            selectedDate = key;
            renderSelectedDay();
        });

        calendarGrid.appendChild(cell);
    }
}

function renderSelectedDay(){
    const q = (searchInput.value || '').toLowerCase();
    if(!selectedDate){
        const today = new Date();
        selectedDate = formatDateKey(today);
    }
    selectedDateLabel.textContent = new Date(selectedDate).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });

    const dayEvents = events.filter(e => dateInRange(selectedDate, e.start, e.end));
    const filtered = dayEvents.filter(e =>
        e.participant.toLowerCase().includes(q) ||
        (e.judul || '').toLowerCase().includes(q) ||
        (e.statusLabel || '').toLowerCase().includes(q)
    );

    dayCount.textContent = filtered.length ? `${filtered.length} kegiatan` : '';

    if(filtered.length === 0){
        selectedDayList.innerHTML = '<div class="text-center py-8 text-gray-500">Tidak ada jadwal pada tanggal ini.</div>';
        return;
    }

    const html = filtered.map(e => `
        <div class="flex items-start justify-between p-4 mb-3 bg-gray-50 rounded-lg border">
            <div class="flex-1 min-w-0 pr-4">
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusClass(e.status)}">${e.statusLabel}</span>
                        ${e.hari ? `<span class="text-xs text-gray-500">${e.hari}</span>` : ''}
                </div>
                <h3 class="text-sm font-semibold text-gray-900 truncate">${escapeHtml(e.participant)}</h3>
                ${e.judul ? `<p class=\"text-sm text-gray-700 truncate\">${escapeHtml(e.judul)}</p>` : ''}
                <p class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-clock mr-1"></i>${e.start} ${e.startTime || ''} - ${e.end} ${e.endTime || ''}
                </p>
            </div>
            <div class="flex flex-col gap-2 w-40 flex-shrink-0">
                <a href="{{ url('mentor/participants') }}/${e.participantId}" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium text-center"><i class="fas fa-eye mr-1"></i> Detail</a>
                ${e.wa ? `<a target=\"_blank\" href=\"https://wa.me/${e.wa}\" class=\"bg-green-100 hover:bg-green-200 text-green-700 px-3 py-1.5 rounded-lg text-xs font-medium text-center\"><i class=\"fab fa-whatsapp mr-1\"></i> Chat</a>` : ''}
            </div>
        </div>
    `).join('');

    selectedDayList.innerHTML = html;
}

function statusClass(status){
    switch(status){
        case 'scheduled': return 'bg-blue-100 text-blue-800';
        case 'ongoing': return 'bg-green-100 text-green-800';
        case 'completed': return 'bg-gray-100 text-gray-800';
        case 'cancelled': return 'bg-red-100 text-red-800';
        default: return 'bg-gray-100 text-gray-800';
    }
}

function escapeHtml(s){
    return (s || '').replace(/[&<>"]+/g, function (m) {
        return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[m];
    });
}

// Navigation
document.getElementById('prevMonth').addEventListener('click', () => {
    current.setMonth(current.getMonth() - 1);
    renderCalendar();
    renderSelectedDay();
});

document.getElementById('nextMonth').addEventListener('click', () => {
    current.setMonth(current.getMonth() + 1);
    renderCalendar();
    renderSelectedDay();
});

// Search filter
searchInput.addEventListener('input', () => {
    renderCalendar();
    renderSelectedDay();
});

// Initialize
(function init(){
    renderCalendar();
    const today = new Date();
    selectedDate = formatDateKey(today);
    renderSelectedDay();
})();
</script>
@endpush
@endsection