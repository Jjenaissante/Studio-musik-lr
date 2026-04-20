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
                    <form id="booking-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Anda" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nomor HP *</label>
                                <input type="tel" class="form-control" id="no_hp" name="no_hp" placeholder="0812..." required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Pilih Studio *</label>
                                <select class="form-control" id="studio" name="studio" required>
                                    <option value="">-- Pilih Studio --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pilih Ruangan *</label>
                                <select class="form-control" id="ruangan" name="ruangan" required>
                                    <option value="">-- Pilih Ruangan --</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Tanggal *</label>
                                <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="Pilih Tanggal" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jam Mulai *</label>
                                <input type="text" class="form-control" id="jam_mulai" name="jam_mulai" placeholder="--:--" readonly required>
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
        // 1. Inisialisasi Tanggal (Flatpickr)
        flatpickr("#tanggal", {
            minDate: "today",
            dateFormat: "Y-m-d",
        });

        // 2. Inisialisasi Jam Scrolling (Flatpickr Time Picker)
        flatpickr("#jam_mulai", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            minuteIncrement: 30, // Loncat per 30 menit
        });
    });
</script>
@endpush