<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kalender Booking - StudioMusik Jjenaissante</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
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

        /* Calendar Container */
        .calendar-container {
            padding: 3rem 0;
        }

        .calendar-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .calendar-nav {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .calendar-nav button {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .calendar-nav button:hover {
            background: var(--primary-dark);
        }

        .calendar-nav button:disabled {
            background: var(--gray-300);
            cursor: not-allowed;
        }

        .calendar-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .calendar-filter {
            display: flex;
            align-items: center;
            gap: 0.5rem;
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

        /* Calendar Grid */
        .calendar-grid {
            background: white;
            border-radius: 0.75rem;
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background: var(--primary-color);
            color: white;
        }

        .calendar-day-header {
            padding: 1rem;
            text-align: center;
            font-weight: 600;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .calendar-day-header:last-child {
            border-right: none;
        }

        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .calendar-day {
            min-height: 120px;
            padding: 0.5rem;
            border-right: 1px solid var(--gray-200);
            border-bottom: 1px solid var(--gray-200);
            cursor: pointer;
            transition: background 0.3s ease;
            position: relative;
        }

        .calendar-day:hover {
            background: rgba(79, 70, 229, 0.05);
        }

        .calendar-day.other-month {
            background: var(--gray-100);
            color: var(--gray-400);
        }

        .calendar-day.today {
            background: rgba(79, 70, 229, 0.1);
            font-weight: 600;
        }

        .calendar-day.has-bookings {
            background: rgba(16, 185, 129, 0.1);
        }

        .day-number {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .booking-count {
            background: var(--primary-color);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            display: inline-block;
            margin-bottom: 0.25rem;
        }

        .booking-preview {
            font-size: 0.75rem;
            color: #b91c1c; /* dark red text */
            background: #fee2e2; /* light red background */
            border-left: 3px solid #ef4444; /* solid red indicator */
            padding: 3px 6px;
            border-radius: 4px;
            margin-bottom: 0.25rem;
            font-weight: 500;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            transition: all 0.2s ease;
        }

        .booking-preview:hover {
            transform: scale(1.02);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            filter: brightness(0.95);
        }

        /* Sidebar */
        .calendar-sidebar {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 2rem;
            margin-top: 2rem;
        }

        .booking-details {
            background: white;
            border-radius: 0.75rem;
            box-shadow: var(--shadow-md);
            padding: 1.5rem;
            height: fit-content;
        }

        .booking-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .booking-item {
            padding: 1rem;
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .booking-item:hover {
            border-color: var(--primary-color);
            box-shadow: var(--shadow-sm);
        }

        .booking-time {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        .booking-studio {
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-bottom: 0.25rem;
        }

        .booking-room {
            font-size: 0.875rem;
            color: var(--gray-700);
        }

        .booking-status {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 0.5rem;
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
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
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

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
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
            .calendar-sidebar {
                grid-template-columns: 1fr;
            }

            .calendar-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .calendar-nav {
                justify-content: center;
            }

            .calendar-day {
                min-height: 80px;
                padding: 0.25rem;
            }

            .calendar-day-header {
                padding: 0.5rem;
                font-size: 0.875rem;
            }

            .booking-preview {
                display: none;
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
            <a href="{{ route('home') }}" class="nav-logo">
                <i class="fas fa-music"></i>
                <span>StudioMusik Jjenaissante</span>
            </a>
            
            <ul class="nav-menu" id="nav-menu">
                <li><a href="{{ route('home') }}" class="nav-link">Beranda</a></li>
                <li><a href="{{ route('home') }}#studios" class="nav-link">Studio</a></li>
                <li><a href="{{ route('calendar') }}" class="nav-link active">Kalender</a></li>
                <li><a href="{{ route('home') }}#booking" class="nav-link">Booking</a></li>
                @if(session('logged_in'))
                    @if(session('role') === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard Admin</a></li>
                    @else
                        <li><a href="{{ route('history') }}" class="nav-link">Riwayat</a></li>
                        <li class="nav-item-notification">
                            <button class="nav-notification-btn" id="notification-btn" title="Notifikasi">
                                <i class="fas fa-bell"></i>
                                <span class="notification-badge" id="notification-badge" style="display: none;">0</span>
                            </button>
                            <div class="notification-dropdown" id="notification-dropdown">
                                <div class="notification-header">
                                    <span>Notifikasi</span>
                                    <button id="mark-all-read-btn">Tandai semua dibaca</button>
                                </div>
                                <div class="notification-body" id="notification-list">
                                    <div class="notification-loading">Memuat notifikasi...</div>
                                </div>
                            </div>
                        </li>
                    @endif
                    <li id="auth-section">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span class="nav-link"><i class="fas fa-user-circle"></i> {{ session('user_name') }}</span>
                            <a href="#" onclick="handleLogout()" style="color: var(--danger-color); font-size: 1.2rem;" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
                        </div>
                    </li>
                @else
                    <li><a href="{{ route('history') }}" class="nav-link">Riwayat</a></li>
                    <li id="auth-section">
                        <a href="{{ route('login') }}" class="nav-link" style="background: var(--primary-color); color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; margin-left: 1rem;">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                @endif
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
            <h1><i class="fas fa-calendar-alt"></i> Kalender Booking</h1>
            <p>Lihat jadwal booking studio musik dan pilih tanggal yang tersedia</p>
        </div>
    </section>

    <!-- Calendar Section -->
    <section class="calendar-container">
        <div class="container">
            <!-- Calendar Controls -->
            <div class="calendar-controls">
                <div class="calendar-nav">
                    <button id="prev-month" title="Bulan Sebelumnya">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <h2 class="calendar-title" id="current-month"></h2>
                    <button id="next-month" title="Bulan Berikutnya">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                
                <div class="calendar-filter">
                    <label for="studio-filter">Studio:</label>
                    <select class="form-control" id="studio-filter" style="width: 200px;">
                        <option value="">Semua Studio</option>
                    </select>
                </div>
            </div>

            <!-- Calendar Sidebar -->
            <div class="calendar-sidebar">
                <!-- Calendar Grid -->
                <div class="calendar-grid">
                    <div class="calendar-header">
                        <div class="calendar-day-header">Minggu</div>
                        <div class="calendar-day-header">Senin</div>
                        <div class="calendar-day-header">Selasa</div>
                        <div class="calendar-day-header">Rabu</div>
                        <div class="calendar-day-header">Kamis</div>
                        <div class="calendar-day-header">Jumat</div>
                        <div class="calendar-day-header">Sabtu</div>
                    </div>
                    <div class="calendar-days" id="calendar-days">
                        <!-- Calendar days will be generated here -->
                    </div>
                </div>

                <!-- Booking Details Sidebar -->
                <div class="booking-details">
                    <h3><i class="fas fa-info-circle"></i> Detail Tanggal</h3>
                    <div id="selected-date-info">
                        <p style="color: var(--gray-600); text-align: center; padding: 2rem 0;">
                            Klik pada tanggal untuk melihat detail booking
                        </p>
                    </div>
                    
                    <div class="booking-list" id="booking-list" style="display: none;">
                        <!-- Booking list will be loaded here -->
                    </div>
                    
                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-200);">
                        <button class="btn btn-primary" style="width: 100%;" onclick="openBookingForm()">
                            <i class="fas fa-plus"></i> Booking Baru
                        </button>
                        <button class="btn btn-outline" style="width: 100%; margin-top: 0.5rem;" onclick="window.location.href='{{ route('home') }}#booking'">
                            <i class="fas fa-arrow-right"></i> Form Booking
                        </button>
                    </div>
                </div>
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
        // Set dynamic APP_URL globally for all fetch requests
        const path = window.location.pathname;
        const publicIndex = path.indexOf('/public');
        const basePath = publicIndex !== -1 ? path.substring(0, publicIndex + 7) : '';
        window.APP_URL = window.location.origin + basePath;

        // Global variables
        let currentDate = new Date();
        let studiosData = [];
        let allBookings = [];
        let currentUser = null;
        let selectedDate = null;

        // Initialize calendar
        document.addEventListener('DOMContentLoaded', function() {
            checkAuthStatus();
            loadStudios();
            loadAllBookings();
            setupEventListeners();
            renderCalendar();
        });

        // Session dari server
        window.sessionUser = {
            logged_in: {{ session('logged_in') ? 'true' : 'false' }},
            user_id: {{ session('user_id', 'null') }},
            user_name: @json(session('user_name')),
            role: @json(session('role')),
        };

        // Check authentication status dari session
        function checkAuthStatus() {
            if (window.sessionUser && window.sessionUser.logged_in) {
                currentUser = window.sessionUser;
            }
        }

        async function handleLogout() {
            try {
                const res = await fetch(window.APP_URL + '/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                });
                const data = await res.json();
                if (data.success) window.location.href = data.redirect_url || '/';
            } catch(e) { window.location.href = '/'; }
        }

        // Auth section ditangani server-side via Blade

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

            // Calendar navigation
            document.getElementById('prev-month').addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });

            document.getElementById('next-month').addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });

            // Studio filter - reload data dari server
            document.getElementById('studio-filter').addEventListener('change', function() {
                allBookings = [];
                loadAllBookings();
            });

            // Modal close
            document.getElementById('modal-close').addEventListener('click', closeModal);
            document.getElementById('modal').addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });
        }

        // Load studios
        async function loadStudios() {
            try {
                const response = await fetch(window.APP_URL + '/api/studios');
                const result = await response.json();
                
                if (result.success) {
                    studiosData = result.data;
                    populateStudioFilter();
                }
            } catch (error) {
                console.error('Error loading studios:', error);
            }
        }

        // Populate studio filter
        function populateStudioFilter() {
            const select = document.getElementById('studio-filter');
            
            studiosData.forEach(studio => {
                const option = document.createElement('option');
                option.value = studio.id_studio;
                option.textContent = studio.nama_studio;
                select.appendChild(option);
            });
        }

        // Load all bookings (public endpoint - no login required)
        async function loadAllBookings() {
            try {
                const year  = currentDate.getFullYear();
                const month = currentDate.getMonth() + 1;
                const studioId = document.getElementById('studio-filter').value;
                let url = window.APP_URL + `/api/bookings/calendar?year=${year}&month=${month}`;
                if (studioId) url += `&id_studio=${studioId}`;
                
                const response = await fetch(url);
                const result = await response.json();
                
                if (result.success) {
                    allBookings = result.data;
                    renderCalendar();
                }
            } catch (error) {
                console.error('Error loading bookings:', error);
            }
        }

        // Render calendar
        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            // Update month title
            const monthNames = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            document.getElementById('current-month').textContent = `${monthNames[month]} ${year}`;
            
            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startingDayOfWeek = firstDay.getDay();
            
            // Filter sudah dilakukan di server sisi - tidak perlu filter client side
            let filteredBookings = allBookings;
            
            // Clear calendar
            const calendarDays = document.getElementById('calendar-days');
            calendarDays.innerHTML = '';
            
            // Add empty cells for days before the first day of the month
            for (let i = 0; i < startingDayOfWeek; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-day other-month';
                calendarDays.appendChild(emptyDay);
            }
            
            // Add days of the month
            const today = new Date();
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                
                const currentDateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                
                // Check if it's today
                if (year === today.getFullYear() && 
                    month === today.getMonth() && 
                    day === today.getDate()) {
                    dayElement.classList.add('today');
                }
                
                // Day number
                const dayNumber = document.createElement('div');
                dayNumber.className = 'day-number';
                dayNumber.textContent = day;
                dayElement.appendChild(dayNumber);
                
                // Get bookings for this day
                const dayBookings = filteredBookings.filter(booking => 
                    booking.tanggal_booking === currentDateStr
                );
                
                if (dayBookings.length > 0) {
                    dayElement.classList.add('has-bookings');
                    
                    // Show booking count
                    const countElement = document.createElement('div');
                    countElement.className = 'booking-count';
                    countElement.textContent = `${dayBookings.length} booking`;
                    dayElement.appendChild(countElement);
                }
                
                // Add click event
                dayElement.addEventListener('click', () => {
                    selectedDate = currentDateStr;
                    showDateDetails(currentDateStr, dayBookings);
                });
                
                calendarDays.appendChild(dayElement);
            }
        }

        // Show date details
        function showDateDetails(dateStr, bookings) {
            const date = new Date(dateStr);
            const formattedDate = date.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            
            const bookingList = document.getElementById('booking-list');
            const selectedDateInfo = document.getElementById('selected-date-info');
            
            selectedDateInfo.innerHTML = `
                <h4 style="margin-bottom: 1rem; color: var(--primary-color);">
                    <i class="fas fa-calendar-day"></i> ${formattedDate}
                </h4>
                <p style="margin-bottom: 0.5rem;">
                    <strong>Total Booking:</strong> ${bookings.length} booking
                </p>
                ${bookings.length === 0 ? '<p style="color: var(--gray-600);">Tanggal ini tersedia untuk booking</p>' : ''}
            `;
            
            if (bookings.length > 0) {
                bookingList.style.display = 'block';
                bookingList.innerHTML = '';
                
                bookings.forEach(booking => {
                    const item = document.createElement('div');
                    item.className = 'booking-item';
                    item.style.cssText = `
                        border-left: 4px solid var(--danger-color);
                        padding: 12px;
                        background: #fff5f5;
                        margin-bottom: 10px;
                        border-radius: 8px;
                        cursor: pointer;
                        box-shadow: var(--shadow-sm);
                        transition: all 0.2s ease;
                    `;
                    
                    item.addEventListener('mouseenter', () => {
                        item.style.transform = 'translateX(3px)';
                        item.style.background = '#fee2e2';
                    });
                    item.addEventListener('mouseleave', () => {
                        item.style.transform = 'none';
                        item.style.background = '#fff5f5';
                    });

                    item.innerHTML = `
                        <div style="font-size: 0.85rem; line-height: 1.6; color: var(--gray-900); text-align: left;">
                            <i class="fas fa-exclamation-triangle" style="color: var(--danger-color); margin-right: 6px;"></i>
                            Pada tanggal <strong>${formattedDate}</strong>, ruangan <strong>${booking.nama_ruangan}</strong> di <strong>${booking.nama_studio}</strong> sudah dibooking pada jam <strong>${booking.jam_mulai} - ${booking.jam_selesai}</strong>.
                        </div>
                        <div style="display: flex; justify-content: flex-end; margin-top: 6px;">
                            <span class="booking-status status-${booking.status_booking}" style="font-size: 0.7rem; padding: 2px 8px; border-radius: 99px;">
                                ${getStatusLabel(booking.status_booking)}
                            </span>
                        </div>
                    `;
                    
                    item.addEventListener('click', () => {
                        showBookingDetail(booking);
                    });
                    
                    bookingList.appendChild(item);
                });
            } else {
                bookingList.style.display = 'none';
            }
        }

        // Show booking detail
        function showBookingDetail(booking) {
            showModal('Detail Booking', `
                <div style="line-height: 1.8;">
                    <p><strong>ID Booking:</strong> ${booking.id_booking}</p>
                    <p><strong>Studio:</strong> ${booking.nama_studio}</p>
                    <p><strong>Ruangan:</strong> ${booking.nama_ruangan}</p>
                    <p><strong>Tanggal:</strong> ${formatDate(booking.tanggal_booking)}</p>
                    <p><strong>Jam:</strong> ${booking.jam_mulai} - ${booking.jam_selesai}</p>
                    <p><strong>Durasi:</strong> ${booking.durasi} jam</p>
                    <p><strong>Total Bayar:</strong> ${formatCurrency(booking.total_bayar)}</p>
                    <p><strong>Status:</strong> <span class="booking-status status-${booking.status_booking}">${getStatusLabel(booking.status_booking)}</span></p>
                    <p><strong>Pelanggan:</strong> ${booking.nama_user}</p>
                </div>
            `);
        }

        // Open booking form
        function openBookingForm() {
            if (!currentUser || !currentUser.logged_in) {
                showModal('Login Diperlukan', `
                    <div class="text-center">
                        <i class="fas fa-sign-in-alt" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
                        <p style="margin-bottom: 1rem;">Silakan login terlebih dahulu untuk melakukan booking.</p>
                        <a href="/login" class="btn btn-primary">Login</a>
                        <a href="/register" class="btn btn-outline" style="margin-left: 0.5rem;">Daftar</a>
                    </div>
                `);
                return;
            }
            
            if (!selectedDate) {
                showModal('Pilih Tanggal', '<p>Silakan pilih tanggal terlebih dahulu untuk melakukan booking.</p>');
                return;
            }
            
            // Redirect ke form booking
            window.location.href = `/?date=${selectedDate}#booking`;
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
    </script>
    <script src="{{ asset('notifications.js') }}"></script>
</body>
</html>