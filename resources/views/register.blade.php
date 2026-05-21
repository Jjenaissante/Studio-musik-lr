<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - StudioMusik Jjenaissante</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #3730a3;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
            --gray-900: #111827;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
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
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .auth-container {
            width: 100%;
            max-width: 500px;
        }

        .auth-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .auth-header {
            background: var(--primary-color);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .auth-header h2 {
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        .auth-header p {
            opacity: 0.9;
        }

        .auth-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--gray-700);
        }

        .input-group {
            position: relative;
        }

        .input-group .form-control {
            width: 100%;
            padding: 0.75rem 0.75rem 0.75rem 3rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .input-group .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .input-group .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-600);
        }

        .btn-primary {
            width: 100%;
            padding: 0.75rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            font-size: 1rem;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-primary:disabled {
            background: var(--gray-300);
            cursor: not-allowed;
        }

        .auth-footer {
            text-align: center;
            padding: 1.5rem;
            border-top: 1px solid var(--gray-200);
        }

        .auth-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .alert-error {
            background: #fee2e2;
            color: #ef4444;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #d1fae5;
            color: #10b981;
            border: 1px solid #a7f3d0;
        }

        .password-strength {
            margin-top: 0.5rem;
            height: 4px;
            background: var(--gray-200);
            border-radius: 2px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
        }

        .strength-weak {
            background: var(--danger-color);
            width: 33%;
        }

        .strength-medium {
            background: var(--warning-color);
            width: 66%;
        }

        .strength-strong {
            background: var(--success-color);
            width: 100%;
        }

        .loading {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 480px) {
            body {
                padding: 1rem;
            }

            .auth-header,
            .auth-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2><i class="fas fa-music"></i> StudioMusik Jjenaissante</h2>
                <p>Buat akun baru untuk booking studio</p>
            </div>
            
            <div class="auth-body">
                <div id="alert-container"></div>
                
                <form id="register-form">
                    <div class="form-group">
                        <label class="form-label" for="nama">Nama Lengkap *</label>
                        <div class="input-group">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" id="nama" class="form-control" placeholder="Nama lengkap Anda" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">Email *</label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" class="form-control" placeholder="email@contoh.com" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="no_hp">Nomor HP</label>
                        <div class="input-group">
                            <i class="fas fa-phone input-icon"></i>
                            <input type="tel" id="no_hp" class="form-control" placeholder="081234567890">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="password">Password *</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" class="form-control" placeholder="Minimal 8 karakter" required>
                        </div>
                        <div class="password-strength">
                            <div class="password-strength-bar" id="password-strength-bar"></div>
                        </div>
                        <small style="color: var(--gray-600); margin-top: 0.25rem; display: block;">
                            Password minimal 8 karakter
                        </small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="confirm_password">Konfirmasi Password *</label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="confirm_password" class="form-control" placeholder="Ulangi password" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-primary" id="btn-submit">
                        <i class="fas fa-user-plus"></i> Daftar Sekarang
                    </button>
                </form>
            </div>
            
            <div class="auth-footer">
                <p>Sudah punya akun? <a href="login.html">Login di sini</a></p>
            </div>
        </div>
    </div>

    <script>
        // Check if user is already logged in
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
                    // User is already logged in, redirect to home
                    window.location.href = 'index.html';
                }
            } catch (error) {
                console.log('User not logged in');
            }
        }

        // Setup event listeners
        function setupEventListeners() {
            // Password strength indicator
            document.getElementById('password').addEventListener('input', checkPasswordStrength);
            
            // Form submission
            document.getElementById('register-form').addEventListener('submit', handleRegisterSubmit);
        }

        // Check password strength
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('password-strength-bar');
            
            // Remove existing classes
            strengthBar.className = 'password-strength-bar';
            
            if (password.length === 0) {
                strengthBar.style.width = '0%';
                return;
            }
            
            let strength = 0;
            
            // Length check
            if (password.length >= 8) strength += 1;
            if (password.length >= 12) strength += 1;
            
            // Character variety checks
            if (/[a-z]/.test(password)) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            
            // Apply strength classes
            if (strength <= 2) {
                strengthBar.classList.add('strength-weak');
            } else if (strength <= 4) {
                strengthBar.classList.add('strength-medium');
            } else {
                strengthBar.classList.add('strength-strong');
            }
        }

        // Handle register form submission
        async function handleRegisterSubmit(e) {
            e.preventDefault();
            
            const btnSubmit = document.getElementById('btn-submit');
            const nama = document.getElementById('nama').value.trim();
            const email = document.getElementById('email').value.trim();
            const no_hp = document.getElementById('no_hp').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            // Clear previous alerts
            clearAlerts();

            // Validation
            if (!nama || !email || !password) {
                showAlert('Nama, email, dan password wajib diisi!', 'error');
                return;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showAlert('Format email tidak valid!', 'error');
                return;
            }

            // Password validation
            if (password.length < 8) {
                showAlert('Password minimal 8 karakter!', 'error');
                return;
            }

            // Password confirmation
            if (password !== confirmPassword) {
                showAlert('Password dan konfirmasi password tidak cocok!', 'error');
                return;
            }

            // Phone validation (if provided)
            if (no_hp && !/^\d{10,15}$/.test(no_hp.replace(/[^\d]/g, ''))) {
                showAlert('Format nomor HP tidak valid!', 'error');
                return;
            }

            // Disable button and show loading
            btnSubmit.innerHTML = '<span class="loading"></span>Memproses...';
            btnSubmit.disabled = true;

            try {
                const response = await fetch('auth.php?action=register', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        name: nama,
                        email: email,
                        no_hp: no_hp,
                        password: password
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showAlert('Registrasi berhasil! Redirecting ke halaman login...', 'success');
                    
                    // Redirect after 2 seconds
                    setTimeout(() => {
                        window.location.href = 'login.html';
                    }, 2000);
                } else {
                    showAlert(result.message, 'error');
                    btnSubmit.innerHTML = '<i class="fas fa-user-plus"></i> Daftar Sekarang';
                    btnSubmit.disabled = false;
                }
            } catch (error) {
                console.error('Registration Error:', error);
                showAlert('Gagal terhubung ke server. Pastikan koneksi internet stabil atau hubungi admin.', 'error');
                btnSubmit.innerHTML = '<i class="fas fa-user-plus"></i> Daftar Sekarang';
                btnSubmit.disabled = false;
            }
        }

        // Show alert message
        function showAlert(message, type) {
            const alertContainer = document.getElementById('alert-container');
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.textContent = message;
            alertContainer.appendChild(alertDiv);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.parentNode.removeChild(alertDiv);
                }
            }, 5000);
        }

        // Clear all alerts
        function clearAlerts() {
            document.getElementById('alert-container').innerHTML = '';
        }

        // Handle Enter key in form fields
        document.getElementById('nama').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('email').focus();
            }
        });

        document.getElementById('email').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('no_hp').focus();
            }
        });

        document.getElementById('no_hp').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('password').focus();
            }
        });

        document.getElementById('password').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('confirm_password').focus();
            }
        });

        document.getElementById('confirm_password').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('btn-submit').click();
            }
        });

        // Format phone number input
        document.getElementById('no_hp').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            if (value.startsWith('0')) {
                value = value.substring(0, 15);
            }
            e.target.value = value;
        });
    </script>
</body>
</html>