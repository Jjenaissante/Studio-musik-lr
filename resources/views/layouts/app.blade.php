<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - StudioMusik Jjenaissante</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="{{ url('/') }}" class="nav-logo">
                <i class="fas fa-music"></i>
                <span>StudioMusik Jjenaissante</span>
            </a>
            <ul class="nav-menu" id="nav-menu">
                <li><a href="{{ url('/#home') }}" class="nav-link">Beranda</a></li>
                <li><a href="{{ url('/#studios') }}" class="nav-link">Studio</a></li>
                <li><a href="{{ url('/#booking') }}" class="nav-link">Booking</a></li>
                <li><a href="{{ route('calendar') }}" class="nav-link">Kalender</a></li>
                <li><a href="{{ route('history') }}" class="nav-link">Riwayat</a></li>
                <li id="auth-section">
                    @auth
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <a href="{{ route('profile') }}" class="nav-link"><i class="fas fa-user-circle"></i> {{ Auth::user()->nama_user }}</a>
                            <a href="#" onclick="handleLogout()" style="color: var(--danger-color); font-size: 1.2rem;">
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-link" style="background: var(--primary-color); color: white; padding: 0.5rem 1rem; border-radius: 0.5rem;">Login</a>
                    @endauth
                </li>
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
                    <p>Jl. Aji Stone no 32, Batam Selatan</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} StudioMusik Jjenaissante. All rights reserved.</p>
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

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('main.js') }}"></script>
    <script>
        async function handleLogout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                try {
                    const response = await fetch('{{ route('logout') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    const result = await response.json();
                    if (result.success) {
                        window.location.href = '{{ route('login') }}';
                    }
                } catch (error) {
                    console.error('Logout error:', error);
                }
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
