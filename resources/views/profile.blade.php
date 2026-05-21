<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - StudioMusik Jjenaissante</title>
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

        /* Profile Header */
        .profile-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 120px 0 60px;
            margin-top: 70px;
            text-align: center;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 3rem;
            color: white;
            border: 4px solid rgba(255, 255, 255, 0.3);
        }

        .profile-nav {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 1rem 0;
        }

        .profile-nav-container {
            display: flex;
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .profile-nav-item {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--gray-600);
            font-weight: 500;
        }

        .profile-nav-item:hover,
        .profile-nav-item.active {
            background: var(--primary-color);
            color: white;
        }

        .profile-content {
            padding: 3rem 0;
        }

        .profile-section {
            display: none;
        }

        .profile-section.active {
            display: block;
        }

        /* Stats Grid */
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

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .card-text {
            color: var(--gray-600);
            margin-bottom: 1rem;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--gray-700);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .input-group {
            position: relative;
        }

        .input-group .form-control {
            padding-left: 3rem;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-600);
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

        .btn-outline {
            background: transparent;
            color: var(--gray-600);
            border: 1px solid var(--gray-300);
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
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

        /* Switch/Toggle */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--gray-300);
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary-color);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
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
            .profile-nav-container {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .profile-nav-item {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
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

        .flex-col {
            flex-direction: column;
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
                <li><a href="index.html#booking" class="nav-link">Booking</a></li>
                <li><a href="index.html#about" class="nav-link">Tentang</a></li>
            </ul>
            
            <div class="nav-toggle" id="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Profile Header -->
    <section class="profile-header">
        <div class="container">
            <div class="profile-avatar" id="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <h1 id="profile-name">Loading...</h1>
            <p id="profile-email">Loading...</p>
        </div>
    </section>

    <!-- Profile Navigation -->
    <nav class="profile-nav">
        <div class="profile-nav-container">
            <div class="profile-nav-item active" onclick="showSection('overview')">
                <i class="fas fa-chart-bar"></i> Ringkasan
            </div>
            <div class="profile-nav-item" onclick="showSection('profile')">
                <i class="fas fa-user-edit"></i> Edit Profil
            </div>
            <div class="profile-nav-item" onclick="showSection('bookings')">
                <i class="fas fa-calendar-check"></i> Booking Saya
            </div>
            <div class="profile-nav-item" onclick="showSection('settings')">
                <i class="fas fa-cog"></i> Pengaturan
            </div>
        </div>
    </nav>

    <!-- Profile Content -->
    <section class="profile-content">
        <div class="container">
            
            <!-- Overview Section -->
            <div id="overview-section" class="profile-section">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon primary">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="total-bookings-stat">0</h3>
                            <p>Total Booking</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="completed-bookings-stat">0</h3>
                            <p>Booking Selesai</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="pending-bookings-stat">0</h3>
                            <p>Menunggu Konfirmasi</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon info">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="stat-info">
                            <h3 id="total-spent-stat">Rp 0</h3>
                            <p>Total Pengeluaran</p>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-history"></i> Booking Terbaru</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID Booking</th>
                                        <th>Studio</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="recent-bookings-profile">
                                    <!-- Recent bookings will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Edit Profile Section -->
            <div id="profile-section" class="profile-section">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-user-edit"></i> Edit Profil</h3>
                    </div>
                    <div class="card-body">
                        <form id="profile-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="edit-nama">Nama Lengkap *</label>
                                    <div class="input-group">
                                        <i class="fas fa-user input-icon"></i>
                                        <input type="text" class="form-control" id="edit-nama" name="nama_user" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="edit-no-hp">Nomor HP</label>
                                    <div class="input-group">
                                        <i class="fas fa-phone input-icon"></i>
                                        <input type="tel" class="form-control" id="edit-no-hp" name="no_hp">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="edit-email">Email *</label>
                                <div class="input-group">
                                    <i class="fas fa-envelope input-icon"></i>
                                    <input type="email" class="form-control" id="edit-email" name="email" required readonly style="background: var(--gray-100);">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="edit-alamat">Alamat</label>
                                <textarea class="form-control" id="edit-alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- My Bookings Section -->
            <div id="bookings-section" class="profile-section">
                <div class="card">
                    <div class="card-header flex flex-between flex-items-center">
                        <h3><i class="fas fa-calendar-check"></i> Semua Booking Saya</h3>
                        <div style="display: flex; gap: 0.5rem;">
                            <select class="form-control" id="filter-status-profile" style="width: auto;">
                                <option value="">Semua Status</option>
                                <option value="pending">Menunggu</option>
                                <option value="confirmed">Terkonfirmasi</option>
                                <option value="completed">Selesai</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </div>
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
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="all-bookings-profile">
                                    <!-- All bookings will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Settings Section -->
            <div id="settings-section" class="profile-section">
                <div class="grid grid-2" style="gap: 2rem;">
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-lock"></i> Ubah Password</h3>
                        </div>
                        <div class="card-body">
                            <form id="password-form">
                                <div class="form-group">
                                    <label class="form-label" for="current-password">Password Saat Ini</label>
                                    <input type="password" class="form-control" id="current-password" name="current_password" required>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="new-password">Password Baru</label>
                                    <input type="password" class="form-control" id="new-password" name="new_password" required minlength="8">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="confirm-new-password">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="confirm-new-password" name="confirm_new_password" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key"></i> Ubah Password
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-bell"></i> Notifikasi</h3>
                        </div>
                        <div class="card-body">
                            <div style="margin-bottom: 1.5rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                    <div>
                                        <h4 style="margin-bottom: 0.25rem;">Email Notifikasi</h4>
                                        <p style="color: var(--gray-600); font-size: 0.875rem;">Terima notifikasi via email</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" id="email-notifications" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                    <div>
                                        <h4 style="margin-bottom: 0.25rem;">SMS Notifikasi</h4>
                                        <p style="color: var(--gray-600); font-size: 0.875rem;">Terima notifikasi via SMS</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" id="sms-notifications">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                                
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <h4 style="margin-bottom: 0.25rem;">Promo & Newsletter</h4>
                                        <p style="color: var(--gray-600); font-size: 0.875rem;">Info promo dan penawaran spesial</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" id="promo-notifications" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                            
                            <button class="btn btn-primary" onclick="saveNotificationSettings()">
                                <i class="fas fa-save"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="card" style="margin-top: 2rem;">
                    <div class="card-header">
                        <h3><i class="fas fa-trash"></i> Hapus Akun</h3>
                    </div>
                    <div class="card-body">
                        <p style="color: var(--gray-600); margin-bottom: 1rem;">
                            Menghapus akun akan menghapus semua data Anda termasuk riwayat booking. 
                            Tindakan ini tidak dapat dibatalkan.
                        </p>
                        <button class="btn btn-danger" onclick="deleteAccount()">
                            <i class="fas fa-trash"></i> Hapus Akun Saya
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
                    <p><i class="fas fa-phone"></i> +62 812-3456-7890</p>
                    <p><i class="fas fa-envelope"></i> info@studiomusik.com</p>
                    <p><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2026 StudioMusik. All rights reserved.</p>
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
                    updateProfileHeader();
                    loadOverviewData();
                } else {
                    window.location.href = 'login.html';
                }
            } catch (error) {
                window.location.href = 'login.html';
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

            // Modal close
            document.getElementById('modal-close').addEventListener('click', closeModal);
            document.getElementById('modal').addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });

            // Form submissions
            document.getElementById('profile-form').addEventListener('submit', handleProfileUpdate);
            document.getElementById('password-form').addEventListener('submit', handlePasswordChange);
            
            // Filter
            document.getElementById('filter-status-profile').addEventListener('change', loadUserBookings);
        }

        // Update profile header
        function updateProfileHeader() {
            if (currentUser) {
                document.getElementById('profile-name').textContent = currentUser.nama_user;
                document.getElementById('profile-email').textContent = currentUser.email;
                
                // Set avatar initial
                const avatar = document.getElementById('profile-avatar');
                const initial = currentUser.nama_user.charAt(0).toUpperCase();
                avatar.innerHTML = `<span style="font-size: 3rem; font-weight: bold;">${initial}</span>`;
                
                // Pre-fill profile form
                document.getElementById('edit-nama').value = currentUser.nama_user;
                document.getElementById('edit-email').value = currentUser.email;
                document.getElementById('edit-no_hp').value = currentUser.no_hp || '';
            }
        }

        // Show profile section
        function showSection(sectionName) {
            // Hide all sections
            document.querySelectorAll('.profile-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Show selected section
            document.getElementById(sectionName + '-section').classList.add('active');
            
            // Update navigation
            document.querySelectorAll('.profile-nav-item').forEach(item => {
                item.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Load section data
            switch(sectionName) {
                case 'overview':
                    loadOverviewData();
                    break;
                case 'profile':
                    loadProfileData();
                    break;
                case 'bookings':
                    loadUserBookings();
                    break;
            }
        }

        // Load overview data
        async function loadOverviewData() {
            if (!currentUser) return;
            
            try {
                const response = await fetch(`api.php?endpoint=bookings&user_id=${currentUser.id_user}`);
                const result = await response.json();
                
                if (result.success) {
                    userBookings = result.data;
                    
                    // Update stats
                    document.getElementById('total-bookings-stat').textContent = userBookings.length;
                    document.getElementById('completed-bookings-stat').textContent = 
                        userBookings.filter(b => b.status_booking === 'completed').length;
                    document.getElementById('pending-bookings-stat').textContent = 
                        userBookings.filter(b => b.status_booking === 'pending').length;
                    
                    const totalSpent = userBookings
                        .filter(b => b.status_booking === 'confirmed' || b.status_booking === 'completed')
                        .reduce((sum, b) => sum + parseInt(b.total_bayar || 0), 0);
                    
                    document.getElementById('total-spent-stat').textContent = formatCurrency(totalSpent);
                    
                    // Load recent bookings
                    loadRecentBookingsProfile();
                }
            } catch (error) {
                console.error('Error loading overview data:', error);
            }
        }

        // Load recent bookings for profile
        function loadRecentBookingsProfile() {
            const recentBookings = userBookings
                .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
                .slice(0, 5);
            
            const tableBody = document.getElementById('recent-bookings-profile');
            tableBody.innerHTML = '';

            recentBookings.forEach(booking => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><strong>${booking.id_booking}</strong></td>
                    <td>${booking.nama_studio}</td>
                    <td>${formatDate(booking.tanggal_booking)}</td>
                    <td>${booking.jam_mulai} - ${booking.jam_selesai}</td>
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
                        ${booking.status_booking === 'pending' ? `
                            <button class="btn btn-sm btn-danger" onclick="cancelBooking('${booking.id_booking}')">
                                <i class="fas fa-times"></i>
                            </button>
                        ` : ''}
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Load profile data
        function loadProfileData() {
            // Data already loaded in checkAuthStatus
        }

        // Load user bookings
        function loadUserBookings() {
            const statusFilter = document.getElementById('filter-status-profile').value;
            let filteredBookings = userBookings;

            if (statusFilter) {
                filteredBookings = userBookings.filter(b => b.status_booking === statusFilter);
            }

            const tableBody = document.getElementById('all-bookings-profile');
            tableBody.innerHTML = '';

            filteredBookings.forEach(booking => {
                const row = document.createElement('tr');
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
                        <div style="display: flex; gap: 0.25rem;">
                            <button class="btn btn-sm btn-primary" onclick="showBookingDetail('${booking.id_booking}')">
                                <i class="fas fa-eye"></i>
                            </button>
                            ${booking.status_booking === 'pending' ? `
                                <button class="btn btn-sm btn-danger" onclick="cancelBooking('${booking.id_booking}')">
                                    <i class="fas fa-times"></i>
                                </button>
                            ` : ''}
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Handle profile update
        async function handleProfileUpdate(e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = {
                nama_user: formData.get('nama_user'),
                no_hp: formData.get('no_hp'),
                alamat: formData.get('alamat')
            };

            try {
                const response = await fetch('api.php?endpoint=update-profile', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    showAlert('Profil berhasil diperbarui!', 'success');
                    // Update current user data
                    currentUser.nama_user = data.nama_user;
                    currentUser.no_hp = data.no_hp;
                    updateProfileHeader();
                } else {
                    showAlert(result.message, 'error');
                }
            } catch (error) {
                showAlert('Gagal memperbarui profil', 'error');
            }
        }

        // Handle password change
        async function handlePasswordChange(e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = {
                current_password: formData.get('current_password'),
                new_password: formData.get('new_password'),
                confirm_password: formData.get('confirm_new_password')
            };

            if (data.new_password !== data.confirm_password) {
                showAlert('Password baru dan konfirmasi tidak cocok!', 'error');
                return;
            }

            if (data.new_password.length < 8) {
                showAlert('Password baru minimal 8 karakter!', 'error');
                return;
            }

            try {
                const response = await fetch('api.php?endpoint=change-password', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    showAlert('Password berhasil diubah!', 'success');
                    e.target.reset();
                } else {
                    showAlert(result.message, 'error');
                }
            } catch (error) {
                showAlert('Gagal mengubah password', 'error');
            }
        }

        // Cancel booking
        async function cancelBooking(bookingId) {
            if (confirm('Apakah Anda yakin ingin membatalkan booking ini?')) {
                try {
                    const response = await fetch('api.php?endpoint=cancel-booking', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id_booking: bookingId })
                    });

                    const result = await response.json();

                    if (result.success) {
                        showAlert('Booking berhasil dibatalkan', 'success');
                        loadOverviewData();
                        loadUserBookings();
                    } else {
                        showAlert(result.message, 'error');
                    }
                } catch (error) {
                    showAlert('Gagal membatalkan booking', 'error');
                }
            }
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

        // Save notification settings
        function saveNotificationSettings() {
            const emailNotif = document.getElementById('email-notifications').checked;
            const smsNotif = document.getElementById('sms-notifications').checked;
            const promoNotif = document.getElementById('promo-notifications').checked;
            
            // Save to localStorage (simulation)
            localStorage.setItem('notificationSettings', JSON.stringify({
                email: emailNotif,
                sms: smsNotif,
                promo: promoNotif
            }));
            
            showAlert('Pengaturan notifikasi berhasil disimpan!', 'success');
        }

        // Delete account
        function deleteAccount() {
            if (confirm('Apakah Anda yakin ingin menghapus akun? Semua data akan hilang permanen.')) {
                if (confirm('Yakin sekali? Tindakan ini tidak dapat dibatalkan.')) {
                    showAlert('Akun berhasil dihapus. Terima kasih telah menggunakan layanan kami.', 'success');
                    setTimeout(() => {
                        // Clear session and redirect
                        localStorage.removeItem('user');
                        window.location.href = 'login.html';
                    }, 2000);
                }
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

        // Load notification settings
        const savedSettings = localStorage.getItem('notificationSettings');
        if (savedSettings) {
            const settings = JSON.parse(savedSettings);
            document.getElementById('email-notifications').checked = settings.email;
            document.getElementById('sms-notifications').checked = settings.sms;
            document.getElementById('promo-notifications').checked = settings.promo;
        }
    </script>
</body>
</html>