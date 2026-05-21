@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-dark: #3730a3;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-600: #4b5563;
        --gray-900: #111827;
    }
    body { background-color: var(--gray-100); }
    main { width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 80vh; padding: 20px; }
    .login-container { max-width: 450px; width: 100%; padding: 2.5rem; background: #ffffff; border-radius: 1rem; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); }
    .login-header { text-align: center; margin-bottom: 2rem; }
    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem; }
    .form-control { width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 0.5rem; }
    .btn { width: 100%; padding: 0.75rem; border-radius: 0.5rem; font-weight: 500; cursor: pointer; transition: all 0.2s; border: none; }
    .btn-primary { background: var(--primary-color); color: white; }
    .alert { padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem; }
    .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
    .loading { display: inline-block; width: 1rem; height: 1rem; border: 2px solid rgba(255,255,255,0.3); border-radius: 50%; border-top-color: white; animation: spin 1s infinite linear; }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="login-container">
    <div class="login-header">
        <h1>Selamat Datang Kembali</h1>
        <p>Masuk untuk mengelola booking studio musik Anda</p>
    </div>

    <div id="alert-container"></div>

    <form id="loginForm">
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">Alamat Email</label>
            <input type="email" id="email" class="form-control" placeholder="nama@email.com" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" id="btnSubmit" class="btn btn-primary">
            Login Sekarang
        </button>
    </form>

    <div style="text-align: center; margin-top: 2rem;">
        Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
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
            const response = await fetch('{{ route('login') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email, password })
            });

            const result = await response.json();
            if (result.success) {
                alertContainer.innerHTML = '<div class="alert alert-success">Login berhasil! Mengalihkan...</div>';
                setTimeout(() => { window.location.href = result.user.role === 'admin' ? '{{ route('admin.dashboard') }}' : '{{ url('/') }}'; }, 1000);
            } else {
                alertContainer.innerHTML = `<div class="alert alert-error">${result.message}</div>`;
                btnSubmit.innerHTML = 'Login Sekarang';
                btnSubmit.disabled = false;
            }
        } catch (error) {
            alertContainer.innerHTML = '<div class="alert alert-error">Gagal terhubung ke server.</div>';
            btnSubmit.innerHTML = 'Login Sekarang';
            btnSubmit.disabled = false;
        }
    });
</script>
@endpush
