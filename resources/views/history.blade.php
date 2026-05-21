<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Booking - StudioMusik Jjenaissante</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
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
            --gray-900: #111827;
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

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--gray-200);
            z-index: 1000;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.25rem;
        }

        .nav-logo i {
            margin-right: 0.5rem;
            font-size: 1.5rem;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            align-items: center;
        }

        .nav-menu li {
            margin-left: 2rem;
        }

        .nav-link {
            text-decoration: none;
            color: var(--gray-600);
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color);
        }

        .nav-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .nav-toggle span {
            width: 25px;
            height: 3px;
            background: var(--gray-600);
            margin: 3px 0;
            transition: 0.3s;
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 120px 0 60px;
            margin-top: 70px;
            text-align: center;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* History Content */
        .history-content {
            padding: 3rem 0;
        }

        .history-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
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

        /* Stats */
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
            text-align: center;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin: 0 auto 1rem;
        }

        .stat-icon.primary { background: var(--primary-color); }
        .stat-icon.success { background: var(--accent-color); }
        .stat-icon.warning { background: var(--secondary-color); }
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

        /* Cards */
        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 2rem;
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

        /* Table */
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

        /* Status Badges */
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

        /* Buttons */
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

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn-outline {
            background: transparent;
            color: var(--gray-600);
            border: 1px solid var(--gray-300);
        }

        .btn-sm {
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
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

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-600);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: var(--gray-300);
        }

        .empty-state h3 {
            margin-bottom: 0.5rem;
            color: var(--gray-700);
        }

        /* Footer */
        .footer {
            background: var(--gray-900);
            color: white;
            padding: 3rem 0 1rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .footer-section p {
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }

        .footer-section a {
            color: #9ca3af;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--primary-color);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #374151;
            color: #6b7280;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .history-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .table {
                font-size: 0.75rem;
            }

            .table th,
            .table td {
                padding: 0.5rem;
            }

            .nav-menu {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 70px);
                background: white;
                flex-direction: column;
                justify-content: flex-start;
                align-items: center;
                transition: 0.3s;
                box-shadow: var(--shadow-lg);
                padding-top: 2rem;
            }

            .nav-menu.active {
                left: 0;
            }

            .nav-toggle {
                display: flex;
            }
        }

        /* Utility Classes */
        .flex {
            display: flex;
        }

        .flex-between {
            justify-content: space-between;
        }

        .flex-center {
            justify-content: center;
        }

        .flex-items-center {
            align-items: center;
        }

        .text-center {
            text-align: center;
        }

        .mt-1 { margin-top: 1rem; }
        .mt-2 { margin-top: 2rem; }
        .mb-1 { margin-bottom: 1rem; }
        .mb-2 { margin-bottom: 2rem; }
        .p-0 { padding: 0; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="index.html" class="nav-logo">
                <i class="fas fa-music"></i>
                <span>StudioMusik Jjenaissante</span>
            </a>
            
            <ul class="nav-menu" id="nav-menu">
                <li><a href="index.html" class="nav-link">Beranda</a></li>
                <li><a href="index.html#studios" class="nav-link">Studio</a></li>
                <li><a href="calendar.html" class="nav-link">Kalender</a></li>
                <li><a href="history.html" class="nav-link active">Riwayat</a></li>
                <li><a href="index.html#about" class="nav-link">Tentang</a></li>
                <li id="auth-section">
                    <a href="login.html" class="nav-link" id="login-btn" style="background: var(--primary-color); color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; margin-left: 1rem;">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </li>
            </ul>
            
            <div class="nav-toggle" id="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1><i class="fas fa-history"></i> Riwayat Booking</h1>
            <p>Lihat semua booking yang pernah Anda lakukan</p>
        </div>
    </section>

    <!-- History Content -->
    <section class="history-content">
        <div class="container">
            <!-- Stats -->
            <div class="stats-grid" id="stats-grid">
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
                        <h3 id="completed-bookings">0</h3>
                        <p>Booking Selesai</p>
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
                    <div class="stat-icon info">
                        <i class="fas fa-money-bill"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="total-spent">Rp 0</h3>
                        <p>Total Pengeluaran</p>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <div class="history-controls">
                <div>
                    <label for="filter-status" style="margin-right: 0.5rem;">Filter Status:</label>
                    <select class="form-control" id="filter-status" style="width: auto;">
                        <option value="">Semua Status</option>
                        <option value="pending">Menunggu</option>
                        <option value="confirmed">Terkonfirmasi</option>
                        <option value="completed">Selesai</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>
                
                <div>
                    <button class="btn btn-outline" onclick="exportHistory()">
                        <i class="fas fa-download"></i> Export PDF
                    </button>
                </div>
            </div>

            <!-- Booking History Table -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-list"></i> Semua Booking</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Booking</th>
                                    <th>Studio & Ruangan</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Durasi</th>
                                    <th>Total Bayar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="history-table">
                                <!-- Booking history will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="empty-state" style="display: none;">
                <i class="fas fa-calendar-times"></i>
                <h3>Belum Ada Booking</h3>
                <p>Anda belum memiliki riwayat booking. Mulai booking studio sekarang!</p>
                <button class="btn btn-primary" onclick="window.location.href='index.html#booking'" style="margin-top: 1rem;">
                    <i class="fas fa-plus"></i> Booking Sekarang
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>StudioMusik Jjenaissante</h3>
                    <p>Platform booking studio musik online yang memudahkan Anda dalam menyewa studio musik profesional dengan fasilitas lengkap.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Layanan</h3>
                    <a href="#">Recording Studio</a>
                    <a href="#">Practice Room</a>
                    <a href="#">Mixing & Mastering</a>
                    <a href="#">Rental Alat Musik</a>
                </div>
                
                <div class="footer-section">
                    <h3>Kontak</h3>
                    <p><i class="fas fa-phone"></i> +62 831-8258-6472</p>
                    <p><i class="fas fa-envelope"></i> info@studiomusik.com</p>
                    <p><i class="fas fa-map-marker-alt"></i> Batam Selatan, Indonesia</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 StudioMusik. All rights reserved.</p>
            </div>
        </div>
    </footer>

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
        let currentUser = null;
        let userBookings = [];
        let filteredBookings = [];

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            checkAuthStatus();
            setupEventListeners();
        });

        // Check authentication status
        async function checkAuthStatus() {
            try {
                const response = await fetch('api.php?endpoint=me');
                const result = await response.json();
                
                if (result.success) {
                    currentUser = result.user;
                    updateAuthSection();
                    loadUserHistory();
                } else {
                    showModal('Login Diperlukan', `
                        <div class="text-center">
                            <i class="fas fa-sign-in-alt" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
                            <p>Silakan login terlebih dahulu untuk melihat riwayat booking.</p>
                            <button class="btn btn-primary" onclick="window.location.href='login.html'">Login</button>
                            <button class="btn btn-outline" onclick="window.location.href='index.html'" style="margin-left: 0.5rem;">Kembali</button>
                        </div>
                    `);
                }
            } catch (error) {
                console.error('Error checking auth status:', error);
                showModal('Error', '<p>Gagal memeriksa status login. Silakan coba lagi.</p>');
            }
        }

        // Update auth section
        function updateAuthSection() {
            const authSection = document.getElementById('auth-section');
            if (currentUser) {
                authSection.innerHTML = `
                    <div class="nav-link" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;" onclick="window.location.href='profile.html'">
                        <i class="fas fa-user-circle"></i>
                        <span>${currentUser.nama_user}</span>
                    </div>
                `;
            }
        }

        // Setup event listeners
        function setupEventListeners() {
            // Mobile menu toggle
            const navToggle = document.getElementById('nav-toggle');
            const navMenu = document.getElementById('nav-menu');
            
            if (navToggle && navMenu) {
                navToggle.addEventListener('click', function() {
                    navMenu.classList.toggle('active');
                });
            }

            // Filter status
            document.getElementById('filter-status').addEventListener('change', filterBookings);

            // Modal close
            document.getElementById('modal-close').addEventListener('click', closeModal);
            document.getElementById('modal').addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });
        }

        // Load user history
        async function loadUserHistory() {
            if (!currentUser) return;
            
            try {
                const response = await fetch(`api.php?endpoint=bookings&user_id=${currentUser.id_user}`);
                const result = await response.json();
                
                if (result.success) {
                    userBookings = result.data;
                    filteredBookings = [...userBookings];
                    displayHistory();
                    updateStats();
                } else {
                    showEmptyState();
                }
            } catch (error) {
                console.error('Error loading user history:', error);
                showModal('Error', '<p>Gagal memuat riwayat booking. Silakan coba lagi.</p>');
            }
        }

        // Display history
        function displayHistory() {
            const tableBody = document.getElementById('history-table');
            const emptyState = document.getElementById('empty-state');
            
            if (filteredBookings.length === 0) {
                tableBody.innerHTML = '';
                emptyState.style.display = 'block';
                return;
            }
            
            emptyState.style.display = 'none';
            tableBody.innerHTML = '';
            
            filteredBookings.forEach(booking => {
                const row = document.createElement('tr');

                let actionBtns = `
                    <button class="btn btn-sm btn-primary" onclick="showBookingDetail('${booking.id_booking}')">
                        <i class="fas fa-eye"></i>
                    </button>
                `;

                // Logic Tombol Bayar
                // Muncul jika status 'pending' DAN (belum ada bukti OR status_pembayaran bukan 'paid'/'waiting_verification')
                // Namun simplifikasinya: Jika status booking 'pending', kita cek status_pembayaran

                const isPaidOrWaiting = booking.status_pembayaran === 'waiting_verification' || booking.status_pembayaran === 'paid';

                if (booking.status_booking === 'pending' && !isPaidOrWaiting) {
                    actionBtns += `
                        <button class="btn btn-sm btn-accent" onclick="showPaymentModal('${booking.id_booking}', '${formatCurrency(booking.total_bayar)}')" title="Bayar Sekarang">
                            <i class="fas fa-money-bill-wave"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="cancelBooking('${booking.id_booking}')" title="Batalkan">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                } else if (booking.status_booking === 'pending' && isPaidOrWaiting) {
                     actionBtns += `<span style="font-size:0.75rem; color:#f59e0b; margin-left:5px;">Verifikasi...</span>`;
                }

                if (booking.status_booking === 'confirmed') {
                    actionBtns += `
                        <button class="btn btn-sm btn-success" onclick="showReceipt('${booking.id_booking}')" title="Lihat Struk" style="background:#10b981; color:white;">
                            <i class="fas fa-receipt"></i>
                        </button>
                    `;
                }

                row.innerHTML = `
                    <td><strong>${booking.id_booking}</strong></td>
                    <td>
                        <div style="font-weight: 500;">${booking.nama_studio}</div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">${booking.nama_ruangan}</div>
                    </td>
                    <td>
                        <div>${formatDate(booking.tanggal_booking)}</div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">${booking.jam_mulai} - ${booking.jam_selesai}</div>
                    </td>
                    <td>${booking.durasi} jam</td>
                    <td><strong>${formatCurrency(booking.total_bayar)}</strong></td>
                    <td>
                        <span class="status-badge status-${booking.status_booking}">
                            ${getStatusLabel(booking.status_booking)}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.25rem; align-items:center;">
                            ${actionBtns}
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Update stats
        function updateStats() {
            document.getElementById('total-bookings').textContent = userBookings.length;
            document.getElementById('completed-bookings').textContent = 
                userBookings.filter(b => b.status_booking === 'completed').length;
            document.getElementById('pending-bookings').textContent = 
                userBookings.filter(b => b.status_booking === 'pending').length;
            
            const totalSpent = userBookings
                .filter(b => b.status_booking === 'confirmed' || b.status_booking === 'completed')
                .reduce((sum, b) => sum + parseInt(b.total_bayar || 0), 0);
            
            document.getElementById('total-spent').textContent = formatCurrency(totalSpent);
        }

        // Filter bookings
        function filterBookings() {
            const statusFilter = document.getElementById('filter-status').value;
            
            if (!statusFilter) {
                filteredBookings = [...userBookings];
            } else {
                filteredBookings = userBookings.filter(b => b.status_booking === statusFilter);
            }
            
            displayHistory();
        }

        // Show empty state
        function showEmptyState() {
            document.getElementById('history-table').innerHTML = '';
            document.getElementById('empty-state').style.display = 'block';
        }

        // Show booking detail
        function showBookingDetail(bookingId) {
            const booking = userBookings.find(b => b.id_booking === bookingId);
            if (!booking) return;

            showModal('Detail Booking', `
                <div style="line-height: 1.8;">
                    <p><strong>ID Booking:</strong> ${booking.id_booking}</p>
                    <p><strong>Studio:</strong> ${booking.nama_studio}</p>
                    <p><strong>Ruangan:</strong> ${booking.nama_ruangan}</p>
                    <p><strong>Tanggal:</strong> ${formatDate(booking.tanggal_booking)}</p>
                    <p><strong>Jam:</strong> ${booking.jam_mulai} - ${booking.jam_selesai}</p>
                    <p><strong>Durasi:</strong> ${booking.durasi} jam</p>
                    <p><strong>Total Bayar:</strong> ${formatCurrency(booking.total_bayar)}</p>
                    <p><strong>Status:</strong> <span class="status-badge status-${booking.status_booking}">${getStatusLabel(booking.status_booking)}</span></p>
                    ${booking.catatan ? `<p><strong>Catatan:</strong> ${booking.catatan}</p>` : ''}
                </div>
            `);
        }

        // Cancel booking
        function cancelBooking(bookingId) {
            if (confirm('Apakah Anda yakin ingin membatalkan booking ini?')) {
                // In a real implementation, this would call the API
                showAlert('Fitur pembatalan booking akan segera tersedia.', 'info');
            }
        }

        // Export history
        function exportHistory() {
            showAlert('Fitur export PDF akan segera tersedia.', 'info');
        }

        // Utility functions
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        function formatCurrency(amount) {
            return 'Rp ' + parseInt(amount).toLocaleString('id-ID');
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
            const alertClass = type === 'success' ? 'success' : type === 'error' ? 'error' : 'info';
            showModal('Informasi', `
                <div class="test-result ${alertClass}" style="margin-bottom: 1rem;">
                    ${message}
                </div>
                <button class="btn btn-primary" onclick="closeModal()">OK</button>
            `);
        }

        // --- PAYMENT & RECEIPT ---
        function showPaymentModal(bookingId, totalAmount) {
            const html = `
                <div class="payment-modal-body">
                    <div class="payment-qris-container">
                        <img src="img/qris_dummy.svg" alt="QRIS Code">
                    </div>
                    <div class="payment-amount">${totalAmount}</div>

                    <div class="payment-instructions">
                        <strong>Cara Pembayaran:</strong>
                        <ol>
                            <li>Scan QRIS di atas menggunakan e-wallet (GoPay, OVO, Dana, dll) atau Mobile Banking.</li>
                            <li>Periksa nominal pembayaran.</li>
                            <li>Selesaikan pembayaran.</li>
                            <li>Screenshot bukti pembayaran dan upload di bawah ini.</li>
                        </ol>
                    </div>

                    <form id="payment-form" onsubmit="handlePaymentSubmit(event, '${bookingId}')">
                        <div class="upload-area" onclick="document.getElementById('proof_file').click()">
                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                            <div class="upload-text">Klik untuk upload bukti pembayaran</div>
                            <input type="file" id="proof_file" name="bukti_pembayaran" accept="image/*,application/pdf" style="display: none" onchange="previewFile(this)" required>
                            <div class="file-preview" id="file-preview">
                                <img id="preview-img" src="">
                                <p id="filename" style="margin-top:0.5rem; font-size:0.8rem;"></p>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%">
                            <i class="fas fa-check-circle"></i> Konfirmasi Pembayaran
                        </button>
                    </form>
                </div>
            `;
            showModal('Pembayaran', html);
        }

        function previewFile(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('file-preview');
                    const img = document.getElementById('preview-img');

                    if (input.files[0].type.startsWith('image/')) {
                        img.src = e.target.result;
                        img.style.display = 'block';
                    } else {
                        img.style.display = 'none';
                    }

                    document.getElementById('filename').textContent = input.files[0].name;
                    preview.style.display = 'block';
                    document.querySelector('.upload-text').style.display = 'none';
                    document.querySelector('.upload-icon').style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        async function handlePaymentSubmit(e, bookingId) {
            e.preventDefault();
            const form = e.target;
            const fileInput = document.getElementById('proof_file');

            if (!fileInput.files.length) {
                alert('Mohon upload bukti pembayaran');
                return;
            }

            const formData = new FormData();
            formData.append('id_booking', bookingId);
            formData.append('bukti_pembayaran', fileInput.files[0]);

            const btn = form.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="loading"></span> Mengupload...';
            btn.disabled = true;

            try {
                const response = await fetch('api.php?endpoint=upload-proof', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    showModal('Sukses', `
                        <div class="text-center">
                            <i class="fas fa-check-circle" style="font-size: 4rem; color: var(--accent-color); margin-bottom: 1rem;"></i>
                            <h3>Pembayaran Berhasil Dikirim!</h3>
                            <p>Admin akan segera memverifikasi pembayaran Anda.</p>
                        </div>
                    `);
                    setTimeout(() => {
                        closeModal();
                        loadUserHistory();
                    }, 2000);
                } else {
                    alert('Gagal: ' + result.message);
                }
            } catch (err) {
                alert('Terjadi kesalahan saat upload.');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }

        function showReceipt(bookingId) {
            const booking = userBookings.find(b => b.id_booking === bookingId);
            if (!booking) return;

            const html = `
                <div style="border: 2px dashed #333; padding: 20px; text-align: center; position: relative;">
                    <div style="font-size: 2rem; color: #10b981; font-weight: bold; border: 3px solid #10b981; display: inline-block; padding: 5px 20px; transform: rotate(-10deg); position: absolute; top: 20px; right: 20px; opacity: 0.5;">
                        LUNAS
                    </div>

                    <h2 style="margin-bottom: 5px;"><i class="fas fa-music"></i> StudioMusik</h2>
                    <p style="font-size: 0.8rem; margin-bottom: 20px;">Jl. Aji Stone no 32, Batam Selatan</p>

                    <hr style="border-top: 1px dashed #ccc; margin: 15px 0;">

                    <div style="text-align: left; margin-bottom: 20px;">
                        <p><strong>ID Booking:</strong> ${booking.id_booking}</p>
                        <p><strong>Tanggal:</strong> ${formatDate(booking.tanggal_booking)}</p>
                        <p><strong>Pelanggan:</strong> ${booking.nama_user || currentUser.nama_user}</p>
                    </div>

                    <table style="width: 100%; text-align: left; margin-bottom: 20px; border-collapse: collapse;">
                        <tr style="border-bottom: 1px solid #eee;">
                            <th style="padding: 5px;">Item</th>
                            <th style="padding: 5px; text-align: right;">Harga</th>
                        </tr>
                        <tr>
                            <td style="padding: 5px;">
                                ${booking.nama_studio} - ${booking.nama_ruangan}<br>
                                <small>${booking.jam_mulai} - ${booking.jam_selesai} (${booking.durasi} Jam)</small>
                            </td>
                            <td style="padding: 5px; text-align: right;">
                                ${formatCurrency(booking.total_bayar)}
                            </td>
                        </tr>
                        <tr style="border-top: 1px solid #333; font-weight: bold;">
                            <td style="padding: 10px 5px;">TOTAL</td>
                            <td style="padding: 10px 5px; text-align: right;">${formatCurrency(booking.total_bayar)}</td>
                        </tr>
                    </table>

                    <p style="font-size: 0.8rem; color: #666;">Terima kasih telah melakukan booking di StudioMusik Jjenaissante.</p>
                    <p style="font-size: 0.8rem; color: #666; margin-top: 5px;">Simpan bukti ini sebagai tiket masuk.</p>

                    <div style="margin-top: 20px;">
                        <button class="btn btn-primary" onclick="window.print()">
                            <i class="fas fa-print"></i> Cetak / Simpan PDF
                        </button>
                    </div>
                </div>
            `;
            showModal('E-Receipt', html);
        }
    </script>
</body>
</html>