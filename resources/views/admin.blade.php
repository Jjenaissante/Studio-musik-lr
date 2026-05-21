@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    main { margin-left: 250px; }
    @media (max-width: 768px) { main { margin-left: 0; } }
</style>
<aside class="admin-sidebar" id="admin-sidebar">
    <div class="sidebar-logo">
        <h2><i class="fas fa-music"></i> StudioMusik</h2>
        <p>Admin Panel</p>
    </div>
    <ul class="sidebar-menu">
        <li><a href="#" class="active" onclick="showSection('dashboard')"><i class="fas fa-chart-bar"></i> Dashboard</a></li>
        <li><a href="#" onclick="showSection('bookings')"><i class="fas fa-calendar-check"></i> Manajemen Booking</a></li>
        <li><a href="#" onclick="showSection('studios')"><i class="fas fa-building"></i> Studio & Ruangan</a></li>
        <li><a href="#" onclick="showSection('users')"><i class="fas fa-users"></i> Data User</a></li>
        <li style="margin-top: 2rem;"><a href="{{ url('/') }}"><i class="fas fa-home"></i> Halaman Utama</a></li>
        <li><a href="#" onclick="handleLogout()"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</aside>

<div class="admin-main">
    <header class="admin-header">
        <div>
            <h2>Dashboard Admin</h2>
            <p>Selamat datang, {{ Auth::user()->nama_user }}!</p>
        </div>
    </header>

    <section id="dashboard-section" class="admin-section active">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-info"><h3 id="total-bookings">0</h3><p>Total Booking</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info"><h3 id="confirmed-bookings">0</h3><p>Terkonfirmasi</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon warning"><i class="fas fa-clock"></i></div>
                <div class="stat-info"><h3 id="pending-bookings">0</h3><p>Menunggu</p></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon danger"><i class="fas fa-dollar-sign"></i></div>
                <div class="stat-info"><h3 id="total-revenue">Rp 0</h3><p>Pendapatan</p></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h3>Booking Terbaru</h3></div>
            <div class="card-body p-0">
                <table class="table">
                    <thead><tr><th>ID</th><th>User</th><th>Studio</th><th>Tanggal</th><th>Status</th><th>Total</th><th>Aksi</th></tr></thead>
                    <tbody id="recent-bookings-table"></tbody>
                </table>
            </div>
        </div>
    </section>

    <section id="bookings-section" class="admin-section">
        <div class="card">
            <div class="card-header flex flex-between">
                <h3>Manajemen Booking</h3>
                <select class="form-control" id="filter-status-admin" onchange="loadAdminBookings()">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="confirmed">Terkonfirmasi</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
            <div class="card-body p-0">
                <table class="table">
                    <thead><tr><th>ID</th><th>User</th><th>Studio</th><th>Waktu</th><th>Total</th><th>Status</th><th>Aksi</th></tr></thead>
                    <tbody id="admin-bookings-table"></tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadDashboardStats();
        loadRecentBookings();
    });

    function showSection(section) {
        document.querySelectorAll('.admin-section').forEach(s => s.classList.remove('active'));
        document.getElementById(section + '-section').classList.add('active');
        if (section === 'bookings') loadAdminBookings();
    }

    async function loadDashboardStats() {
        const res = await fetch('/admin/stats');
        const result = await res.json();
        if (result.success) {
            document.getElementById('total-bookings').textContent = result.data.total_bookings;
            document.getElementById('confirmed-bookings').textContent = result.data.confirmed_bookings;
            document.getElementById('pending-bookings').textContent = result.data.pending_bookings;
            document.getElementById('total-revenue').textContent = 'Rp ' + result.data.total_revenue.toLocaleString();
        }
    }

    async function loadRecentBookings() {
        const res = await fetch('/admin/recent-bookings');
        const result = await res.json();
        if (result.success) {
            const table = document.getElementById('recent-bookings-table');
            table.innerHTML = result.data.map(b => `
                <tr>
                    <td>${b.id_booking}</td>
                    <td>${b.nama_user}</td>
                    <td>${b.nama_studio}</td>
                    <td>${b.tanggal_booking}</td>
                    <td><span class="status-badge status-${b.status_booking}">${b.status_booking}</span></td>
                    <td>Rp ${b.total_bayar.toLocaleString()}</td>
                    <td><button onclick="showDetail('${b.id_booking}')">Detail</button></td>
                </tr>
            `).join('');
        }
    }

    async function loadAdminBookings() {
        const status = document.getElementById('filter-status-admin').value;
        const res = await fetch(`/admin/all-bookings?status=${status}`);
        const result = await res.json();
        if (result.success) {
            const table = document.getElementById('admin-bookings-table');
            table.innerHTML = result.data.map(b => `
                <tr>
                    <td>${b.id_booking}</td>
                    <td>${b.nama_user}</td>
                    <td>${b.nama_studio} - ${b.nama_ruangan}</td>
                    <td>${b.tanggal_booking} ${b.jam_mulai}</td>
                    <td>Rp ${b.total_bayar.toLocaleString()}</td>
                    <td><span class="status-badge status-${b.status_booking}">${b.status_booking}</span></td>
                    <td>
                        <button onclick="confirmBooking('${b.id_booking}')">Confirm</button>
                        <button onclick="cancelBooking('${b.id_booking}')">Cancel</button>
                    </td>
                </tr>
            `).join('');
        }
    }

    async function confirmBooking(id) {
        const res = await fetch('/admin/confirm-booking', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ id_booking: id })
        });
        if ((await res.json()).success) loadAdminBookings();
    }
</script>
@endpush
