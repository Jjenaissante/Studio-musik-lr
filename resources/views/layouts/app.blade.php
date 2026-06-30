<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - StudioMusik Jjenaissante</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body>
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="nav-logo">
                <i class="fas fa-music"></i>
                <span>StudioMusik Jjenaissante</span>
            </a>
            <ul class="nav-menu" id="nav-menu">
                <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('home') }}#studios" class="nav-link">Studio</a></li>
                <li><a href="{{ route('home') }}#booking" class="nav-link">Booking</a></li>
                <li><a href="{{ route('calendar') }}" class="nav-link {{ request()->routeIs('calendar') ? 'active' : '' }}">Kalender</a></li>

                @if(session('logged_in'))
                    @if(session('role') === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard Admin</a></li>
                    @else
                        <li><a href="{{ route('history') }}" class="nav-link {{ request()->routeIs('history') ? 'active' : '' }}">Riwayat</a></li>
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
                            <a href="#" onclick="handleLogout()" style="color: var(--danger-color); font-size: 1.2rem;" title="Logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                        </div>
                    </li>
                @else
                    <li><a href="{{ route('history') }}" class="nav-link">Riwayat</a></li>
                    <li id="auth-section">
                        <a href="{{ route('login') }}" class="nav-link" style="background: var(--primary-color); color: white; padding: 0.5rem 1rem; border-radius: 0.5rem;">Login</a>
                    </li>
                @endif
            </ul>
            <div class="nav-toggle" id="nav-toggle">
                <span></span><span></span><span></span>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>StudioMusik Jjenaissante</h3>
                    <p>Platform booking studio musik online profesional.</p>
                </div>
                <div class="footer-section">
                    <h3>Lokasi</h3>
                    <p>Jl. Aji Stone no 45, Batam Selatan</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 StudioMusik Jjenaissante. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <div class="modal" id="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title">Informasi</h3>
                <button class="modal-close" id="modal-close">&times;</button>
            </div>
            <div class="modal-body" id="modal-body"></div>
        </div>
    </div>

    <script src="{{ asset('main.js') }}"></script>
    <script src="{{ asset('notifications.js') }}"></script>
    <script>
        // Set dynamic APP_URL globally for all fetch requests (CORS/Subfolder safe)
        const path = window.location.pathname;
        const publicIndex = path.indexOf('/public');
        const basePath = publicIndex !== -1 ? path.substring(0, publicIndex + 7) : '';
        window.APP_URL = window.location.origin + basePath;

        // Session info dari server (untuk JS)
        window.sessionUser = {
            logged_in: {{ session('logged_in') ? 'true' : 'false' }},
            user_id: {{ session('user_id', 'null') }},
            user_name: @json(session('user_name')),
            user_email: @json(session('user_email')),
            user_no_hp: @json(session('user_no_hp')),
            role: @json(session('role')),
        };

        // Logout handler
        async function handleLogout() {
            try {
                const res = await fetch(window.APP_URL + '/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                });
                const data = await res.json();
                if (data.success) {
                    window.location.href = data.redirect_url || '/';
                }
            } catch (e) {
                window.location.href = '/';
            }
        }
    </script>
    @stack('scripts')
</body>
</html>