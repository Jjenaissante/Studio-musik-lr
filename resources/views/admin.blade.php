<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manajemen Booking StudioMusik</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #3730a3;
            --secondary-color: #f59e0b;
            --accent-color: #10b981;
            --danger-color: #ef4444;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-900: #111827;
            --light-color: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--gray-900);
            background: var(--gray-100);
        }

        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: var(--gray-900);
            color: white;
            padding: 1rem;
            z-index: 1000;
            overflow-y: auto;
        }

        .admin-main {
            margin-left: 250px;
            min-height: 100vh;
            background: var(--gray-100);
        }

        .admin-header {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-logo {
            text-align: center;
            padding: 1rem 0 2rem;
            border-bottom: 1px solid var(--gray-700);
            margin-bottom: 2rem;
        }

        .sidebar-logo h2 {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .sidebar-logo p {
            font-size: 0.875rem;
            color: var(--gray-400);
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: var(--gray-300);
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: var(--primary-color);
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-icon.primary { background: var(--primary-color); }
        .stat-icon.success { background: var(--accent-color); }
        .stat-icon.warning { background: var(--secondary-color); }
        .stat-icon.danger { background: var(--danger-color); }
        .stat-icon.info { background: #3b82f6; }

        .stat-info h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-info p {
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            background: var(--gray-100);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-body.p-0 {
            padding: 0;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .table th {
            background: var(--gray-100);
            font-weight: 600;
            color: var(--gray-700);
        }

        .table tbody tr:hover {
            background: rgba(79, 70, 229, 0.05);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-accent {
            background: var(--accent-color);
            color: white;
        }

        .btn-accent:hover {
            background: #059669;
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-outline {
            background: transparent;
            color: var(--gray-600);
            border: 1px solid var(--gray-300);
        }

        .btn-outline:hover {
            background: var(--gray-100);
        }

        .btn-sm {
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-pending {
            background: #fef3c7;
            color: #f59e0b;
        }

        .status-confirmed {
            background: #d1fae5;
            color: #10b981;
        }

        .status-completed {
            background: #dbeafe;
            color: #3b82f6;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #ef4444;
        }

        .grid {
            display: grid;
            gap: 1.5rem;
        }

        .grid-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .admin-section {
            padding: 2rem;
        }

        .flex {
            display: flex;
        }

        .flex-between {
            justify-content: space-between;
        }

        .flex-items-center {
            align-items: center;
        }

        .form-control {
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            font-size: 0.875rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 1rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray-600);
        }

        .modal-body {
            padding: 1.5rem;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .admin-sidebar.active {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-header {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .grid-2,
            .grid-3 {
                grid-template-columns: 1fr;
            }

            .table {
                font-size: 0.75rem;
            }

            .table th,
            .table td {
                padding: 0.5rem;
            }
        }

        /* Loading spinner */
        .loading {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Hidden sections */
        .admin-section {
            display: none;
        }

        .admin-section.active {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Admin Sidebar -->
    <aside class="admin-sidebar" id="admin-sidebar">
        <div class="sidebar-logo">
            <h2><i class="fas fa-music"></i> StudioMusik</h2>
            <p style="font-size: 0.875rem; color: var(--gray-400); margin-top: 0.5rem;">Admin Panel</p>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="#" class="active" onclick="showSection('dashboard')">
                    <i class="fas fa-chart-bar"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="showSection('bookings')">
                    <i class="fas fa-calendar-check"></i>
                    <span>Manajemen Booking</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="showSection('studios')">
                    <i class="fas fa-building"></i>
                    <span>Studio & Ruangan</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="showSection('users')">
                    <i class="fas fa-users"></i>
                    <span>Data User</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="showSection('reports')">
                    <i class="fas fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
            </li>
            <li style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid var(--gray-700);">
                <a href="index.html">
                    <i class="fas fa-home"></i>
                    <span>Halaman Utama</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="logout()">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Admin Main Content -->
    <main class="admin-main">
        <!-- Admin Header -->
        <header class="admin-header">
            <div>
                <h2 style="margin-bottom: 0.25rem;">Dashboard Admin</h2>
                <p style="color: var(--gray-600); font-size: 0.875rem;">Selamat datang, Maharaja!</p>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button class="btn btn-outline btn-sm" id="mobile-menu-toggle" style="display: none;">
                    <i class="fas fa-bars"></i>
                </button>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-user-circle" style="font-size: 1.5rem; color: var(--primary-color);"></i>
                    <div>
                        <div style="font-weight: 500;">Admin</div>
                        <div style="font-size: 0.75rem; color: var(--gray-600);">Administrator</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Section -->
        <section id="dashboard-section" class="admin-section">
            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon primary">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="total-bookings">0</h3>
                        <p>Total Booking</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="confirmed-bookings">0</h3>
                        <p>Booking Terkonfirmasi</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="pending-bookings">0</h3>
                        <p>Menunggu Konfirmasi</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon danger">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="total-revenue">Rp 0</h3>
                        <p>Total Pendapatan</p>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="card">
                <div class="card-header flex flex-between flex-items-center">
                    <h3><i class="fas fa-history"></i> Booking Terbaru</h3>
                    <button class="btn btn-outline btn-sm" onclick="showSection('bookings')">
                        Lihat Semua
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Booking</th>
                                    <th>Pelanggan</th>
                                    <th>Studio</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="recent-bookings-table">
                                <!-- Recent bookings will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bookings Management Section -->
        <section id="bookings-section" class="admin-section" style="display: none;">
            <div class="card">
                <div class="card-header flex flex-between flex-items-center">
                    <h3><i class="fas fa-calendar-check"></i> Manajemen Booking</h3>
                    <div style="display: flex; gap: 0.5rem;">
                        <select class="form-control" id="filter-status-admin" style="width: auto;">
                            <option value="">Semua Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="confirmed">Terkonfirmasi</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                        <button class="btn btn-outline btn-sm" onclick="loadAdminBookings()">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pelanggan</th>
                                    <th>Studio & Ruangan</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Durasi</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="admin-bookings-table">
                                <!-- All bookings will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Studios Management Section -->
        <section id="studios-section" class="admin-section" style="display: none;">
            <div class="card">
                <div class="card-header flex flex-between flex-items-center">
                    <h3><i class="fas fa-building"></i> Studio & Ruangan</h3>
                    <button class="btn btn-primary" onclick="showAddStudioModal()">
                        <i class="fas fa-plus"></i> Tambah Studio
                    </button>
                </div>
                <div class="card-body">
                    <div class="grid grid-2" id="studios-management-grid">
                        <!-- Studio management cards will be loaded here -->
                    </div>
                </div>
            </div>
        </section>

        <!-- Users Section -->
        <section id="users-section" class="admin-section" style="display: none;">
            <div class="card">
                <div class="card-header flex flex-between flex-items-center">
                    <h3><i class="fas fa-users"></i> Data User</h3>
                    <button class="btn btn-primary" onclick="showAddUserModal()">
                        <i class="fas fa-plus"></i> Tambah User
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>No. HP</th>
                                    <th>Email</th>
                                    <th>Total Booking</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="users-table">
                                <!-- Users will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Reports Section -->
        <section id="reports-section" class="admin-section" style="display: none;">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-file-alt"></i> Laporan</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-2" style="gap: 2rem;">
                        <div>
                            <h4 style="margin-bottom: 1rem;">Laporan Pendapatan</h4>
                            <div class="form-group">
                                <label class="form-label">Periode</label>
                                <select class="form-control">
                                    <option>Hari Ini</option>
                                    <option>Minggu Ini</option>
                                    <option>Bulan Ini</option>
                                    <option>Tahun Ini</option>
                                </select>
                            </div>
                            <button class="btn btn-primary">
                                <i class="fas fa-download"></i> Download Laporan
                            </button>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 1rem;">Laporan Booking</h4>
                            <div class="form-group">
                                <label class="form-label">Tipe Laporan</label>
                                <select class="form-control">
                                    <option>Semua Booking</option>
                                    <option>Booking per Studio</option>
                                    <option>Booking per Pelanggan</option>
                                </select>
                            </div>
                            <button class="btn btn-primary">
                                <i class="fas fa-download"></i> Download Laporan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal -->
    <div class="modal" id="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title">Modal Title</h3>
                <button class="modal-close" id="modal-close">&times;</button>
            </div>
            <div class="modal-body" id="modal-body">
                <!-- Modal content will be inserted here -->
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let bookingsData = [];
        let studiosData = [];
        let usersData = [];
        let currentUser = null;

        // Initialize admin dashboard
        document.addEventListener('DOMContentLoaded', function() {
            checkAuthStatus();
            loadDashboardStats();
            loadRecentBookings();
            setupEventListeners();
        });

        // Check authentication status
        async function checkAuthStatus() {
            // 1. Cek LocalStorage dulu untuk menghindari redirect visual (flash)
            const localData = localStorage.getItem('user');
            if (!localData) {
                window.location.href = 'login.html';
                return;
            }

            const localUser = JSON.parse(localData);
            if (localUser.role !== 'admin') {
                window.location.href = 'index.html';
                return;
            }

            // Set sementara dari local agar UI muncul
            currentUser = localUser;

            // 2. Verifikasi ke Server
            try {
                const response = await fetch('api.php?endpoint=me&t=' + new Date().getTime());
                const result = await response.json();
                
                if (result.success) {
                    currentUser = result.user;
                    // Pastikan yang login benar-benar admin
                    if (currentUser.role !== 'admin') {
                        window.location.href = 'index.html';
                    }
                } else {
                    // Jika server menolak sesi (session expired)
                    console.error("Session invalid via API");
                    localStorage.removeItem('user');
                    window.location.href = 'login.html';
                }
            } catch (error) {
                console.error("Network error checking auth, staying on page based on localStorage");
            }
        }

        // Show admin section
        function showSection(sectionName) {
            // Hide all sections
            document.querySelectorAll('.admin-section').forEach(section => {
                section.style.display = 'none';
            });
            
            // Show selected section
            const targetSection = document.getElementById(sectionName + '-section');
            if (targetSection) {
                targetSection.style.display = 'block';
            }
            
            // Update active menu
            document.querySelectorAll('.sidebar-menu a').forEach(link => {
                link.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Load section data
            switch(sectionName) {
                case 'dashboard':
                    loadDashboardStats();
                    loadRecentBookings();
                    break;
                case 'bookings':
                    loadAdminBookings();
                    break;
                case 'studios':
                    loadStudiosManagement();
                    break;
                case 'users':
                    loadUsersData();
                    break;
            }
        }

        // Load dashboard statistics
        async function loadDashboardStats() {
            try {
                const response = await fetch('api.php?endpoint=dashboard-stats');
                const result = await response.json();
                
                if (result.success) {
                    const stats = result.data;
                    document.getElementById('total-bookings').textContent = stats.total_bookings || 0;
                    document.getElementById('confirmed-bookings').textContent = stats.confirmed_bookings || 0;
                    document.getElementById('pending-bookings').textContent = stats.pending_bookings || 0;
                    document.getElementById('total-revenue').textContent = formatCurrency(stats.total_revenue || 0);
                }
            } catch (error) {
                console.error('Error loading dashboard stats:', error);
            }
        }

        // Load recent bookings
        async function loadRecentBookings() {
            try {
                const response = await fetch('api.php?endpoint=recent-bookings&limit=5');
                const result = await response.json();
                
                if (result.success) {
                    displayRecentBookings(result.data);
                }
            } catch (error) {
                console.error('Error loading recent bookings:', error);
            }
        }

        // Display recent bookings
        function displayRecentBookings(bookings) {
            const tableBody = document.getElementById('recent-bookings-table');
            tableBody.innerHTML = '';

            bookings.forEach(booking => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><strong>${booking.id_booking}</strong></td>
                    <td>${booking.nama_user}</td>
                    <td>${booking.nama_studio}</td>
                    <td>${formatDate(booking.tanggal_booking)}</td>
                    <td>
                        <span class="status-badge status-${booking.status_booking}">
                            ${getStatusLabel(booking.status_booking)}
                        </span>
                    </td>
                    <td><strong>${formatCurrency(booking.total_bayar)}</strong></td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="showBookingDetail('${booking.id_booking}')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Load admin bookings
        async function loadAdminBookings() {
            const statusFilter = document.getElementById('filter-status-admin').value;
            
            try {
                let url = 'api.php?endpoint=bookings';
                if (statusFilter) {
                    url += `&status=${statusFilter}`;
                }
                
                const response = await fetch(url);
                const result = await response.json();
                
                if (result.success) {
                    bookingsData = result.data;
                    displayAdminBookings(bookingsData);
                }
            } catch (error) {
                console.error('Error loading admin bookings:', error);
            }
        }

        // Display admin bookings
        function displayAdminBookings(bookings) {
            const tableBody = document.getElementById('admin-bookings-table');
            tableBody.innerHTML = '';

            bookings.forEach(booking => {
                const row = document.createElement('tr');

                // Cek apakah ada bukti pembayaran
                let proofBtn = '';
                if (booking.bukti_pembayaran) {
                    proofBtn = `
                        <button class="btn btn-sm btn-info" onclick="showProof('${booking.bukti_pembayaran}')" title="Lihat Bukti Bayar" style="background:#3b82f6; color:white;">
                            <i class="fas fa-receipt"></i>
                        </button>`;
                }

                row.innerHTML = `
                    <td><strong>${booking.id_booking}</strong></td>
                    <td>
                        <div style="font-weight: 500;">${booking.nama_user}</div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">${booking.no_hp}</div>
                    </td>
                    <td>
                        <div style="font-weight: 500;">${booking.nama_studio}</div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">${booking.nama_ruangan}</div>
                    </td>
                    <td>
                        <div>${formatDate(booking.tanggal_booking)}</div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">${booking.jam_mulai} - ${booking.jam_selesai}</div>
                    </td>
                    <td>${booking.durasi} jam</td>
                    <td>
                        <strong>${formatCurrency(booking.total_bayar)}</strong>
                        <div style="font-size: 0.75rem;">${booking.status_pembayaran || '-'}</div>
                    </td>
                    <td>
                        <span class="status-badge status-${booking.status_booking}">
                            ${getStatusLabel(booking.status_booking)}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.25rem;">
                            <button class="btn btn-sm btn-primary" onclick="showBookingDetail('${booking.id_booking}')" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            ${proofBtn}
                            ${booking.status_booking === 'pending' ? `
                                <button class="btn btn-sm btn-accent" onclick="confirmBooking('${booking.id_booking}')" title="Konfirmasi">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="cancelBooking('${booking.id_booking}')" title="Batalkan">
                                    <i class="fas fa-times"></i>
                                </button>
                            ` : ''}
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Load studios management
        async function loadStudiosManagement() {
            try {
                const response = await fetch('api.php?endpoint=studios');
                const result = await response.json();
                
                if (result.success) {
                    studiosData = result.data;
                    displayStudiosManagement(studiosData);
                }
            } catch (error) {
                console.error('Error loading studios:', error);
            }
        }

        // Display studios management
        function displayStudiosManagement(studios) {
            const grid = document.getElementById('studios-management-grid');
            grid.innerHTML = '';

            studios.forEach(studio => {
                studio.ruangan.forEach(ruangan => {
                    const card = document.createElement('div');
                    card.className = 'card';
                    
                    // Simpan data ruangan ke format teks agar bisa dibaca tombol Edit
                    const roomData = JSON.stringify(ruangan).replace(/"/g, '&quot;');
                    
                    card.innerHTML = `
                        <div class="card-body">
                            <h4 style="color: var(--primary-color); margin-bottom: 0.5rem;">${studio.nama_studio}</h4>
                            <h5 style="margin-bottom: 0.5rem;">${ruangan.nama_ruangan}</h5>
                            <p style="color: var(--gray-600); margin-bottom: 0.5rem;">
                                <i class="fas fa-users"></i> Kapasitas: ${ruangan.kapasitas} orang
                            </p>
                            <p style="color: var(--gray-600); margin-bottom: 1rem;">
                                <i class="fas fa-money-bill"></i> Tarif: ${formatCurrency(ruangan.tarif_per_jam)}/jam
                            </p>
                            <p style="color: var(--gray-600); margin-bottom: 1rem;">
                                <i class="fas fa-info-circle"></i> Status: ${ruangan.status}
                            </p>
                            <div style="display: flex; gap: 0.5rem;">
                                <button class="btn btn-sm btn-primary" onclick="openEditRoomModal('${roomData}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="deleteRoom('${ruangan.id_ruangan}')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    `;
                    grid.appendChild(card);
                });
            });
        }

        // Load users data
        async function loadUsersData() {
            try {
                const response = await fetch('api.php?endpoint=users');
                const result = await response.json();
                
                if (result.success) {
                    usersData = result.data;
                    displayUsersData(usersData);
                }
            } catch (error) {
                console.error('Error loading users:', error);
            }
        }

        // Display users data
        function displayUsersData(users) {
            const tableBody = document.getElementById('users-table');
            tableBody.innerHTML = '';

            users.forEach(user => {
                const userBookings = bookingsData.filter(b => b.id_user === user.id_user).length;
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>USR${user.id_user.toString().padStart(3, '0')}</td>
                    <td style="font-weight: 500;">${user.nama_user}</td>
                    <td>${user.no_hp || '-'}</td>
                    <td>${user.email}</td>
                    <td>${userBookings} booking</td>
                    <td>
                        <button class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Confirm booking
        async function confirmBooking(bookingId) {
            if (confirm(`Konfirmasi booking ${bookingId}?`)) {
                try {
                    const response = await fetch('api.php?endpoint=confirm-booking', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id_booking: bookingId })
                    });

                    const result = await response.json();
                    
                    if (result.success) {
                        showAlert('Booking berhasil dikonfirmasi!', 'success');
                        loadAdminBookings();
                        loadDashboardStats();
                    } else {
                        showAlert(result.message, 'error');
                    }
                } catch (error) {
                    showAlert('Gagal mengkonfirmasi booking', 'error');
                }
            }
        }

        // Cancel booking
        async function cancelBooking(bookingId) {
            if (confirm(`Batalkan booking ${bookingId}?`)) {
                try {
                    const response = await fetch('api.php?endpoint=cancel-booking', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id_booking: bookingId })
                    });

                    const result = await response.json();
                    
                    if (result.success) {
                        showAlert('Booking berhasil dibatalkan', 'success');
                        loadAdminBookings();
                        loadDashboardStats();
                    } else {
                        showAlert(result.message, 'error');
                    }
                } catch (error) {
                    showAlert('Gagal membatalkan booking', 'error');
                }
            }
        }

        // Show proof
        function showProof(filename) {
            showModal('Bukti Pembayaran', `
                <div style="text-align:center;">
                    <img src="bukti_pembayaran/${filename}" style="max-width:100%; max-height:500px; border:1px solid #ddd; padding:5px; border-radius:5px;">
                    <div style="margin-top:1rem;">
                        <a href="bukti_pembayaran/${filename}" target="_blank" class="btn btn-primary">
                            <i class="fas fa-external-link-alt"></i> Buka Ukuran Penuh
                        </a>
                    </div>
                </div>
            `);
        }

        // Show booking detail
        function showBookingDetail(bookingId) {
            const booking = bookingsData.find(b => b.id_booking === bookingId);
            if (!booking) return;

            showModal('Detail Booking', `
                <div style="line-height: 1.8;">
                    <p><strong>ID Booking:</strong> ${booking.id_booking}</p>
                    <p><strong>Pelanggan:</strong> ${booking.nama_user}</p>
                    <p><strong>No. HP:</strong> ${booking.no_hp}</p>
                    <p><strong>Studio:</strong> ${booking.nama_studio}</p>
                    <p><strong>Ruangan:</strong> ${booking.nama_ruangan}</p>
                    <p><strong>Tanggal:</strong> ${formatDate(booking.tanggal_booking)}</p>
                    <p><strong>Jam:</strong> ${booking.jam_mulai} - ${booking.jam_selesai}</p>
                    <p><strong>Durasi:</strong> ${booking.durasi} jam</p>
                    <p><strong>Total Bayar:</strong> ${formatCurrency(booking.total_bayar)}</p>
                    <p><strong>Status:</strong> <span class="status-badge status-${booking.status_booking}">${getStatusLabel(booking.status_booking)}</span></p>
                    <p><strong>Status Pembayaran:</strong> ${booking.status_pembayaran || 'Belum dibayar'}</p>
                    ${booking.catatan ? `<p><strong>Catatan:</strong> ${booking.catatan}</p>` : ''}
                    ${booking.bukti_pembayaran ? `<p style="margin-top:10px;"><button class="btn btn-sm btn-info" onclick="showProof('${booking.bukti_pembayaran}')">Lihat Bukti Bayar</button></p>` : ''}
                </div>
            `);
        }

        // Show add studio modal (placeholder)
        function showAddStudioModal() {
            showModal('Tambah Studio', '<p>Fitur tambah studio akan segera tersedia.</p>');
        }

        // Show add user modal (placeholder)
        function showAddUserModal() {
            showModal('Tambah User', '<p>Fitur tambah user akan segera tersedia.</p>');
        }

        // Logout function
        function logout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                // Clear session and redirect
                fetch('auth.php?action=logout', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' }
                }).finally(() => {
                    localStorage.removeItem('user');
                    window.location.href = 'login.html';
                });
            }
        }

        // Utility functions
        function formatCurrency(amount) {
            return 'Rp ' + parseInt(amount).toLocaleString('id-ID');
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        function getStatusLabel(status) {
            const labels = {
                'pending': 'Menunggu',
                'confirmed': 'Terkonfirmasi',
                'completed': 'Selesai',
                'cancelled': 'Dibatalkan'
            };
            return labels[status] || status;
        }

        function showModal(title, content) {
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-body').innerHTML = content;
            document.getElementById('modal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('modal').classList.remove('active');
        }

        function showAlert(message, type) {
            showModal('Informasi', `
                <div class="alert alert-${type}" style="margin-bottom: 1rem;">
                    ${message}
                </div>
                <button class="btn btn-primary" onclick="closeModal()">OK</button>
            `);
        }

        // --- TAMBAHKAN KODE INI DI PALING BAWAH ---

        function setupEventListeners() {
            // 1. Mengaktifkan tombol Silang (X)
            const closeBtn = document.getElementById('modal-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', closeModal);
            }

            // 2. Mengaktifkan fitur tutup jika klik di luar kotak (background gelap)
            const modal = document.getElementById('modal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeModal();
                    }
                });
            }
            
            // 3. Mengaktifkan menu mobile (garis tiga)
            const menuToggle = document.getElementById('mobile-menu-toggle');
            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    document.getElementById('admin-sidebar').classList.toggle('active');
                });
            }
        }

        // --- LOGIKA EDIT & HAPUS (Paste di paling bawah) ---

        // 1. Munculkan Form Edit
        function openEditRoomModal(jsonStr) {
            const r = JSON.parse(jsonStr);
            const html = `
                <form onsubmit="submitEditRoom(event)">
                    <input type="hidden" id="edit_id" value="${r.id_ruangan}">
                    <div style="margin-bottom:1rem">
                        <label>Nama Ruangan</label>
                        <input class="form-control" id="edit_nama" value="${r.nama_ruangan}" required>
                    </div>
                    <div style="margin-bottom:1rem">
                        <label>Kapasitas</label>
                        <input type="number" class="form-control" id="edit_kapasitas" value="${r.kapasitas}" required>
                    </div>
                    <div style="margin-bottom:1rem">
                        <label>Tarif</label>
                        <input type="number" class="form-control" id="edit_tarif" value="${r.tarif_per_jam}" required>
                    </div>
                    <div style="margin-bottom:1rem">
                        <label>Status</label>
                        <select class="form-control" id="edit_status">
                            <option value="available" ${r.status=='available'?'selected':''}>Available</option>
                            <option value="maintenance" ${r.status=='maintenance'?'selected':''}>Maintenance</option>
                            <option value="unavailable" ${r.status=='unavailable'?'selected':''}>Unavailable</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%">Simpan Perubahan</button>
                </form>
            `;
            showModal('Edit Ruangan', html);
        }

        // 2. Kirim Data Edit ke Server
        async function submitEditRoom(e) {
            e.preventDefault();
            const body = {
                id_ruangan: document.getElementById('edit_id').value,
                nama_ruangan: document.getElementById('edit_nama').value,
                kapasitas: document.getElementById('edit_kapasitas').value,
                tarif: document.getElementById('edit_tarif').value,
                status: document.getElementById('edit_status').value
            };
            
            try {
                const res = await fetch('api.php?endpoint=update-room', {
                    method: 'POST', 
                    headers:{'Content-Type':'application/json'}, 
                    body: JSON.stringify(body)
                });
                const json = await res.json();
                if(json.success) { 
                    alert('Berhasil update!'); 
                    closeModal(); 
                    loadStudiosManagement(); // Refresh tampilan
                } else {
                    alert(json.message);
                }
            } catch(err) { alert('Error koneksi'); }
        }

        // 3. Proses Hapus
        async function deleteRoom(id) {
            if(!confirm('Yakin ingin menghapus ruangan ini?')) return;
            try {
                const res = await fetch('api.php?endpoint=delete-room', {
                    method: 'POST', 
                    headers:{'Content-Type':'application/json'}, 
                    body: JSON.stringify({id_ruangan: id})
                });
                const json = await res.json();
                if(json.success) { 
                    alert('Berhasil dihapus'); 
                    loadStudiosManagement(); // Refresh tampilan
                } else {
                    alert('Gagal hapus: ' + json.message);
                }
            } catch(err) { alert('Error koneksi'); }
        }
        
    </script>
</body>
</html>