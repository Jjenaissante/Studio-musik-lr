@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    main { width: 100%; display: flex; justify-content: center; }
    .auth-container { width: 100%; max-width: 500px; }
    .auth-card { background: white; border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); overflow: hidden; }
    .auth-header { background: var(--primary-color); color: white; padding: 2rem; text-align: center; }
    .auth-body { padding: 2rem; }
    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--gray-700); }
    .input-group { position: relative; }
    .input-group .form-control { width: 100%; padding: 0.75rem 0.75rem 0.75rem 3rem; border: 1px solid var(--gray-300); border-radius: 0.5rem; font-size: 1rem; transition: all 0.3s ease; }
    .input-group .input-icon { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--gray-600); }
    .btn-primary { width: 100%; padding: 0.75rem; background: var(--primary-color); color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: background 0.3s ease; font-size: 1rem; }
    .auth-footer { text-align: center; padding: 1.5rem; border-top: 1px solid var(--gray-200); }
    .alert { padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; }
    .alert-error { background: #fee2e2; color: #ef4444; border: 1px solid #fecaca; }
    .alert-success { background: #d1fae5; color: #10b981; border: 1px solid #a7f3d0; }
    .loading { display: inline-block; width: 16px; height: 16px; border: 2px solid rgba(255, 255, 255, 0.3); border-radius: 50%; border-top-color: white; animation: spin 1s ease-in-out infinite; margin-right: 0.5rem; }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2><i class="fas fa-music"></i> StudioMusik Jjenaissante</h2>
            <p>Buat akun baru untuk booking studio</p>
        </div>

        <div class="auth-body">
            <div id="alert-container"></div>
            
            <form id="register-form">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="nama">Nama Lengkap *</label>
                    <div class="input-group">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" id="nama" name="name" class="form-control" placeholder="Nama lengkap Anda" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email *</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="no_hp">Nomor HP</label>
                    <div class="input-group">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="tel" id="no_hp" name="no_hp" class="form-control" placeholder="081234567890">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password *</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                    </div>
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
            <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('register-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const btnSubmit = document.getElementById('btn-submit');
        const name = document.getElementById('nama').value;
        const email = document.getElementById('email').value;
        const no_hp = document.getElementById('no_hp').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        if (password !== confirmPassword) {
            showAlert('Password dan konfirmasi password tidak cocok!', 'error');
            return;
        }

        btnSubmit.innerHTML = '<span class="loading"></span>Memproses...';
        btnSubmit.disabled = true;

        try {
            const response = await fetch('{{ route('register') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name, email, no_hp, password })
            });

            const result = await response.json();

            if (result.success) {
                showAlert('Registrasi berhasil! Redirecting ke halaman login...', 'success');
                setTimeout(() => { window.location.href = '{{ route('login') }}'; }, 2000);
            } else {
                showAlert(result.message || 'Registrasi gagal', 'error');
                btnSubmit.innerHTML = '<i class="fas fa-user-plus"></i> Daftar Sekarang';
                btnSubmit.disabled = false;
            }
        } catch (error) {
            showAlert('Terjadi kesalahan sistem.', 'error');
            btnSubmit.innerHTML = '<i class="fas fa-user-plus"></i> Daftar Sekarang';
            btnSubmit.disabled = false;
        }
    });

    function showAlert(message, type) {
        const container = document.getElementById('alert-container');
        container.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
    }
</script>
@endpush
