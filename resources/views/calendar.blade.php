@extends('layouts.app')

@section('title', 'Kalender Booking')

@section('content')
<div class="container section">
    <div class="section-header">
        <h2 class="section-title">Kalender Ketersediaan</h2>
        <p class="section-subtitle">Lihat jadwal studio yang sudah terisi.</p>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Pilih Studio</label>
                    <select class="form-control" id="filter-studio" onchange="loadRooms()">
                        <option value="">-- Pilih Studio --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Pilih Ruangan</label>
                    <select class="form-control" id="filter-ruangan" onchange="loadSchedule()">
                        <option value="">-- Pilih Ruangan --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal</label>
                    <input type="text" class="form-control" id="filter-date" placeholder="Pilih Tanggal">
                </div>
            </div>

            <div id="calendar-view" style="margin-top: 2rem;">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="schedule-body">
                            <tr><td colspan="3" style="text-align: center;">Pilih ruangan dan tanggal untuk melihat jadwal.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#filter-date", {
            defaultDate: "today",
            onChange: loadSchedule
        });
        loadStudios();
    });

    async function loadStudios() {
        const res = await fetch('/studios');
        const result = await res.json();
        if (result.success) {
            const select = document.getElementById('filter-studio');
            select.innerHTML += result.data.map(s => `<option value="${s.id_studio}">${s.nama_studio}</option>`).join('');
        }
    }

    async function loadRooms() {
        const studioId = document.getElementById('filter-studio').value;
        const res = await fetch(`/studio/${studioId}`);
        const result = await res.json();
        const select = document.getElementById('filter-ruangan');
        select.innerHTML = '<option value="">-- Pilih Ruangan --</option>';
        if (result.success) {
            select.innerHTML += result.data.ruangans.map(r => `<option value="${r.id_ruangan}">${r.nama_ruangan}</option>`).join('');
        }
    }

    async function loadSchedule() {
        const roomId = document.getElementById('filter-ruangan').value;
        const date = document.getElementById('filter-date').value;
        if (!roomId || !date) return;

        const res = await fetch(`/available-slots?id_ruangan=${roomId}&date=${date}`);
        const result = await res.json();
        const tbody = document.getElementById('schedule-body');

        if (result.success) {
            if (result.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" style="text-align: center;">Belum ada booking untuk tanggal ini. Semua slot tersedia!</td></tr>';
            } else {
                tbody.innerHTML = result.data.map(slot => `
                    <tr>
                        <td>${slot.start} - ${slot.end}</td>
                        <td><span class="status-badge status-cancelled">Terisi</span></td>
                        <td>Sudah dibooking</td>
                    </tr>
                `).join('');
            }
        }
    }
</script>
@endpush
