@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container section">
    <div class="section-header">
        <h2 class="section-title">Profil Saya</h2>
        <p class="section-subtitle">Informasi akun Anda.</p>
    </div>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <div class="card-body">
            <div style="text-align: center; margin-bottom: 2rem;">
                <i class="fas fa-user-circle" style="font-size: 5rem; color: var(--primary-color);"></i>
                <h3 style="margin-top: 1rem;">{{ Auth::user()->nama_user }}</h3>
                <span class="status-badge status-completed">{{ ucfirst(Auth::user()->role) }}</span>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" value="{{ Auth::user()->email }}" readonly>
            </div>

            <div class="form-group">
                <label class="form-label">Nomor HP</label>
                <input type="text" class="form-control" value="{{ Auth::user()->no_hp }}" readonly>
            </div>

            <div class="form-group">
                <label class="form-label">Bergabung Sejak</label>
                <input type="text" class="form-control" value="{{ Auth::user()->created_at->format('d F Y') }}" readonly>
            </div>

            <button class="btn btn-primary btn-block" onclick="alert('Fitur edit profil segera hadir!')">Edit Profil</button>
        </div>
    </div>
</div>
@endsection
