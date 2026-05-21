@extends('layouts.app')

@section('title', 'Home')

@section('content')
    {{-- Hero Section --}}
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Booking Studio Musik Jadi Lebih Mudah</h1>
                <p class="hero-subtitle">Pilih studio favoritmu, tentukan waktu, dan nikmati pengalaman bermusik terbaik dengan fasilitas profesional.</p>
                <div class="hero-buttons">
                    <a href="#booking" class="btn btn-primary"><i class="fas fa-calendar-check"></i> Booking Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Studios Section --}}
    <section class="section" id="studios">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Studio Kami</h2>
                <p class="section-subtitle">Fasilitas lengkap dengan kualitas suara terbaik.</p>
            </div>
            <div class="grid grid-3" id="studios-grid">
                @foreach($studios as $s)
                    <div class="card studio-card">
                        <div class="studio-image" style="height: 200px; overflow: hidden;">
                            <img src="{{ $s->foto ? asset('img/'.$s->foto) : 'https://via.placeholder.com/400x200?text='.$s->nama_studio }}"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">{{ $s->nama_studio }}</h3>
                            <p class="card-text"><i class="fas fa-map-marker-alt" style="color: var(--danger-color);"></i> {{ $s->alamat }}</p>
                            <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                                <a href="{{ route('studio.detail', $s->id_studio) }}" class="btn btn-outline" style="flex: 1;">Detail</a>
                                <button onclick="pilihStudioUntukBooking('{{ $s->id_studio }}')" class="btn btn-primary" style="flex: 1;">Booking</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Booking Section --}}
    <section class="section" style="background: var(--gray-100);" id="booking">
        <div class="container">
            <div class="booking-form">
                <div class="form-header">
                    <h3><i class="fas fa-calendar-alt"></i> Form Booking Studio</h3>
                </div>
                <div class="form-body">
                    <form id="booking-form-el">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="nama" value="{{ Auth::user()->nama_user ?? '' }}" readonly required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nomor HP *</label>
                                <input type="tel" class="form-control" id="no_hp" value="{{ Auth::user()->no_hp ?? '' }}" readonly required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Pilih Studio *</label>
                                <select class="form-control" id="studio" required onchange="updateRooms()">
                                    <option value="">-- Pilih Studio --</option>
                                    @foreach($studios as $s)
                                        <option value="{{ $s->id_studio }}">{{ $s->nama_studio }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pilih Ruangan *</label>
                                <select class="form-control" id="ruangan" name="id_ruangan" required>
                                    <option value="">-- Pilih Ruangan --</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Tanggal *</label>
                                <input type="text" class="form-control" id="tanggal" name="tanggal_booking" placeholder="Pilih Tanggal" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jam Mulai *</label>
                                <input type="text" class="form-control" id="jam_mulai" name="jam_mulai" placeholder="--:--" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Durasi *</label>
                                <select class="form-control" id="durasi" name="durasi" required>
                                    <option value="1">1 Jam</option>
                                    <option value="2">2 Jam</option>
                                    <option value="3">3 Jam</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block" style="margin-top: 1rem;">
                            Booking Sekarang!
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#tanggal", { minDate: "today", dateFormat: "Y-m-d" });
        flatpickr("#jam_mulai", { enableTime: true, noCalendar: true, dateFormat: "H:i", time_24hr: true, minuteIncrement: 30 });

        const urlParams = new URLSearchParams(window.location.search);
        const roomId = urlParams.get('room');
        if (roomId) {
            // Logic to pre-select studio and room
        }
    });

    const studios = @json($studios);

    function updateRooms() {
        const studioId = document.getElementById('studio').value;
        const roomSelect = document.getElementById('ruangan');
        roomSelect.innerHTML = '<option value="">-- Pilih Ruangan --</option>';

        const studio = studios.find(s => s.id_studio === studioId);
        if (studio && studio.ruangans) {
            studio.ruangans.forEach(r => {
                roomSelect.innerHTML += `<option value="${r.id_ruangan}">${r.nama_ruangan} (Rp ${number_format(r.tarif_per_jam)}/jam)</option>`;
            });
        }
    }

    function pilihStudioUntukBooking(idStudio) {
        document.getElementById('studio').value = idStudio;
        updateRooms();
        window.location.href = '#booking';
    }

    document.getElementById('booking-form-el').addEventListener('submit', async function(e) {
        e.preventDefault();
        @if(!Auth::check())
            alert('Silakan login terlebih dahulu!');
            window.location.href = '{{ route('login') }}';
            return;
        @endif

        const data = {
            id_ruangan: document.getElementById('ruangan').value,
            tanggal_booking: document.getElementById('tanggal').value,
            jam_mulai: document.getElementById('jam_mulai').value,
            durasi: document.getElementById('durasi').value,
            _token: '{{ csrf_token() }}'
        };

        try {
            const res = await fetch('/booking', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await res.json();
            if (result.success) {
                alert('Booking berhasil dibuat!');
                window.location.href = '{{ route('history') }}';
            } else {
                alert(result.message);
            }
        } catch (err) {
            alert('Gagal membuat booking.');
        }
    });

    function number_format(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>
@endpush
