<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - StudioMusik Jjenaissante</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="/style.css?v={{ time() }}">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #3730a3;
            --gray-100: #3730a3;  
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
            --gray-900: #111827;
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
            background-color: var(--gray-100);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            max-width: 450px;
            width: 100%;
            padding: 2.5rem;
            background: #fefefeff;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: var(--gray-500);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            font-family: inherit;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .login-footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: var(--gray-600);
        }

        .login-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .loading {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <h1>Selamat Datang Kembali!</h1>
            <p>Masuk untuk mengetahui lebih lanjut!</p>
        </div>

        <div id="alert-container"></div>

        <form id="loginForm">
            @csrf {{-- Token keamanan wajib Laravel --}}
            <div class="form-group">
                <label class="form-label" for="email">Alamat Email</label>
                <input type="email" id="email" class="form-control" placeholder="nama@email.com" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" id="btnSubmit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i> Login Sekarang
            </button>
        </form>

        <div class="login-footer">
            Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
        </div>
        <div class="login-footer" style="margin-top: 0.5rem;">
            <a href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
        </div>
    </div>

    <script>
        const path = window.location.pathname;
        const publicIndex = path.indexOf('/public');
        const basePath = publicIndex !== -1 ? path.substring(0, publicIndex + 7) : '';
        window.APP_URL = window.location.origin + basePath;

        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const btnSubmit = document.getElementById('btnSubmit');
            const alertContainer = document.getElementById('alert-container');
            
            alertContainer.innerHTML = '';
            
            btnSubmit.innerHTML = '<span class="loading"></span> Memverifikasi...';
            btnSubmit.disabled = true;

            try {
                const response = await fetch(window.APP_URL + '/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email, password })
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    showAlert('Login berhasil! Mengalihkan...', 'success');
                    setTimeout(() => {
                        window.location.href = result.redirect_url || '/'; 
                    }, 1000);
                } else {
                    showAlert(result.message || 'Email atau password salah.', 'error');
                    btnSubmit.innerHTML = '<i class="fas fa-sign-in-alt"></i> Login Sekarang';
                    btnSubmit.disabled = false;
                }
            } catch (error) {
                console.error('Login Error:', error);
                showAlert('Gagal terhubung ke server. Pastikan koneksi internet stabil atau hubungi admin.', 'error');
                btnSubmit.innerHTML = '<i class="fas fa-sign-in-alt"></i> Login Sekarang';
                btnSubmit.disabled = false;
            }
        });

        function showAlert(message, type) {
            const alertContainer = document.getElementById('alert-container');
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.textContent = message;
            alertContainer.appendChild(alertDiv);

            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.parentNode.removeChild(alertDiv);
                }
            }, 5000);
        }

        document.getElementById('email').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('password').focus();
            }
        });

        document.getElementById('password').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('btnSubmit').click();
            }
        });
    </script>
</body>
</html>