@extends('layouts.app')

@section('title', $studio->nama_studio)

@section('content')
<div class="container section">
    <div class="section-header">
        <h2 class="section-title">{{ $studio->nama_studio }}</h2>
        <p class="section-subtitle">{{ $studio->alamat }}</p>
    </div>

    <div class="grid grid-2">
        <div class="card">
            <div class="studio-image">
                <img src="{{ $studio->foto ? asset('img/'.$studio->foto) : 'https://via.placeholder.com/600x400' }}" style="width: 100%; border-radius: 0.5rem;">
            </div>
            <div class="card-body">
                <h3>Tentang Studio</h3>
                <p>Informasi detail tentang {{ $studio->nama_studio }}.</p>
                <ul style="list-style: none; margin-top: 1rem;">
                    <li><i class="fas fa-phone"></i> {{ $studio->no_telp }}</li>
                    <li><i class="fas fa-envelope"></i> {{ $studio->email }}</li>
                    <li><i class="fas fa-clock"></i> {{ $studio->jam_buka }} - {{ $studio->jam_tutup }}</li>
                </ul>
            </div>
        </div>

        <div>
            <h3>Pilih Ruangan</h3>
            <div class="grid" style="gap: 1rem; margin-top: 1rem;">
                @foreach($studio->ruangans as $ruangan)
                <div class="card">
                    <div class="card-body">
                        <h4>{{ $ruangan->nama_ruangan }}</h4>
                        <p>Kapasitas: {{ $ruangan->kapasitas }} orang</p>
                        <p><strong>Rp {{ number_format($ruangan->tarif_per_jam) }}/jam</strong></p>
                        <button class="btn btn-primary btn-block" style="margin-top: 0.5rem;" onclick="bookRoom('{{ $ruangan->id_ruangan }}')">Pilih Ruangan</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function bookRoom(roomId) {
        window.location.href = `{{ url('/#booking') }}?room=${roomId}`;
    }
</script>
@endpush
