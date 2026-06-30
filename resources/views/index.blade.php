@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <style>
        /* Custom Premium Studio Cards styling */
        .studio-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            margin-bottom: 2rem;
        }

        .studio-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .studio-image-container {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .studio-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .studio-card:hover .studio-image-container img {
            transform: scale(1.05);
        }

        .studio-hours-pill {
            position: absolute;
            bottom: 12px;
            left: 12px;
            background: rgba(79, 70, 229, 0.9);
            backdrop-filter: blur(4px);
            color: white;
            padding: 4px 10px;
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            z-index: 10;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .studio-card-body {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .studio-title-main {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: left;
        }

        .studio-address-row {
            font-size: 0.85rem;
            color: #ef4444;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 1.25rem;
            font-weight: 500;
            text-align: left;
        }

        .studio-address-row i {
            font-size: 0.9rem;
        }

        .ruangan-list-container {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .ruangan-item-card {
            background: #f3f4f6;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.2s ease;
        }

        .ruangan-item-card:hover {
            background: #e5e7eb;
        }

        .ruangan-info-left {
            display: flex;
            flex-direction: column;
            gap: 2px;
            text-align: left;
        }

        .ruangan-name-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .ruangan-capacity-label {
            font-size: 0.75rem;
            color: var(--gray-600);
        }

        .ruangan-price-right {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .btn-booking-action {
            width: 100%;
            padding: 0.75rem 1rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: auto;
            text-align: center;
            display: block;
            text-decoration: none;
        }

        .btn-booking-action:hover {
            background: var(--primary-dark);
        }
    </style>
    {{-- Hero Section --}}
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Booking Studio Musik Jadi Lebih Mudah</h1>
                <p class="hero-subtitle">Pilih studio favoritmu, tentukan waktu, dan nikmati pengalaman bermusik terbaik dengan fasilitas profesional.</p>
                <div class="hero-buttons">
                    <a href="#booking" class="btn btn-primary"><i class="fas fa-calendar-check"></i> Booking Sekarang</a>
                    <a href="{{ route('calendar') }}" class="btn btn-outline" style="margin-left: 1rem; background: transparent; border: 2px solid white; color: white;"><i class="fas fa-calendar-alt"></i> Lihat Kalender</a>
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
                    @if(!session('logged_in'))
                        <p style="color: var(--warning-color, #f59e0b); font-size: 0.9rem; margin-top: 0.5rem;">
                            <i class="fas fa-info-circle"></i> 
                            <a href="{{ route('login') }}" style="color: var(--primary-color);"></a>Login untuk melakukan booking.
                        </p>
                    @endif
                </div>
                <div class="form-body">
                    <form id="booking-form">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="nama" name="nama" 
                                    placeholder="Nama Anda" 
                                    value="{{ session('user_name', '') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nomor HP *</label>
                                <input type="tel" class="form-control" id="no_hp" name="no_hp" placeholder="0812..." required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                    placeholder="email@contoh.com" 
                                    value="{{ session('user_email', '') }}" required>
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
                                    <option value="4">4 Jam</option>
                                    <option value="5">5 Jam</option>
                                    <option value="6">6 Jam</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Catatan / Keterangan</label>
                            <textarea class="form-control" id="catatan" name="catatan" 
                                rows="3" placeholder="Tuliskan kebutuhan khusus, instrumen yang akan dibawa, atau catatan lainnya..."></textarea>
                        </div>

                        <div id="tarif-info" style="display:none; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.5rem; padding: 1rem; margin-top: 0.5rem;">
                            <p style="color: #1e40af; font-weight: 600;"><i class="fas fa-tag"></i> Estimasi Biaya: <span id="estimasi-biaya">Rp 0</span></p>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block" style="margin-top: 1rem;" id="btn-booking">
                            <i class="fas fa-calendar-check"></i> Booking Sekarang!
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
            minuteIncrement: 30,
        });

        // 3. Load studio dropdown
        loadStudiosDropdown();

        // 4. Update estimasi biaya saat ruangan / durasi berubah
        document.getElementById('ruangan').addEventListener('change', updateEstimasi);
        document.getElementById('durasi').addEventListener('change', updateEstimasi);

        // 5. Handle form submit
        document.getElementById('booking-form').addEventListener('submit', handleBookingSubmit);
    });

    let studiosList = [];
    let ruanganList = [];

    async function loadStudiosDropdown() {
        try {
            const res  = await fetch(window.APP_URL + '/api/studios');
            const data = await res.json();
            if (data.success) {
                studiosList = data.data;
                const select = document.getElementById('studio');
                data.data.forEach(s => {
                    const opt = document.createElement('option');
                    opt.value       = s.id_studio;
                    opt.textContent = s.nama_studio;
                    select.appendChild(opt);
                });
                select.addEventListener('change', loadRuanganByStudio);
            }
        } catch (e) {
            console.error('Gagal load studio:', e);
        }
    }

    async function loadRuanganByStudio() {
        const idStudio = document.getElementById('studio').value;
        const select   = document.getElementById('ruangan');
        select.innerHTML = '<option value="">-- Pilih Ruangan --</option>';
        ruanganList = [];
        document.getElementById('tarif-info').style.display = 'none';

        if (!idStudio) return;

        try {
            const res  = await fetch(window.APP_URL + `/api/ruangan?id_studio=${idStudio}`);
            const data = await res.json();
            if (data.success) {
                ruanganList = data.data;
                data.data.forEach(r => {
                    const opt = document.createElement('option');
                    opt.value       = r.id_ruangan;
                    if (r.status === 'maintenance') {
                        opt.textContent = `${r.nama_ruangan} (Sedang Maintenance) - Rp ${Number(r.tarif_per_jam).toLocaleString('id-ID')}/jam`;
                        opt.disabled = true;
                        opt.style.color = '#9ca3af';
                    } else {
                        opt.textContent = `${r.nama_ruangan} - Rp ${Number(r.tarif_per_jam).toLocaleString('id-ID')}/jam`;
                    }
                    opt.dataset.tarif = r.tarif_per_jam;
                    select.appendChild(opt);
                });
            }
        } catch (e) {
            console.error('Gagal load ruangan:', e);
        }
    }

    function updateEstimasi() {
        const select = document.getElementById('ruangan');
        const opt    = select.options[select.selectedIndex];
        const durasi = parseInt(document.getElementById('durasi').value) || 1;
        if (opt && opt.dataset.tarif) {
            const tarif = parseFloat(opt.dataset.tarif);
            const total = tarif * durasi;
            document.getElementById('estimasi-biaya').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('tarif-info').style.display = 'block';
        } else {
            document.getElementById('tarif-info').style.display = 'none';
        }
    }

    async function handleBookingSubmit(e) {
        e.preventDefault();

        // Cek apakah sudah login
        @if(!session('logged_in'))
        showModal('Login Diperlukan', `
            <div style="text-align:center; padding: 1rem;">
                <i class="fas fa-sign-in-alt" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
                <p style="margin-bottom: 1rem;">Anda harus login terlebih dahulu untuk melakukan booking.</p>
                <a href="{{ route('login') }}" class="btn btn-primary" style="margin-right: 0.5rem;">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline">Daftar</a>
            </div>
        `);
        return;
        @endif

        const id_ruangan      = document.getElementById('ruangan').value;
        const tanggal_booking = document.getElementById('tanggal').value;
        const jam_mulai       = document.getElementById('jam_mulai').value;
        const durasi          = document.getElementById('durasi').value;
        const catatan         = document.getElementById('catatan').value;
        const email           = document.getElementById('email').value;
        const no_hp           = document.getElementById('no_hp').value;
        const btn             = document.getElementById('btn-booking');

        if (!id_ruangan || !tanggal_booking || !jam_mulai) {
            showModal('Perhatian', '<p>Lengkapi semua field yang wajib diisi!</p>');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<span class="loading"></span> Memproses...';

        try {
            const res = await fetch(window.APP_URL + '/api/bookings', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ id_ruangan, tanggal_booking, jam_mulai, durasi, catatan, email, no_hp }),
            });

            const result = await res.json();

            if (result.success) {
                e.target.reset();
                showDirectPaymentModal(result.data.id_booking, result.data.total_bayar);
            } else {
                showModal('Gagal', `<p>${result.message}</p>`);
            }
        } catch (err) {
            showModal('Error', `<p>Gagal terhubung ke server: ${err.message}</p>`);
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-calendar-check"></i> Booking Sekarang!';
        }
    }

    // --- DIRECT PAYMENT FLOW ---
    function showDirectPaymentModal(bookingId, totalAmount) {
        const formattedAmount = 'Rp ' + parseInt(totalAmount).toLocaleString('id-ID');
        const html = `
            <div class="payment-modal-body" style="padding: 1rem; text-align: center;">
                <div style="margin-bottom: 1.5rem; color: #10b981;">
                    <i class="fas fa-check-circle" style="font-size: 3rem; margin-bottom: 0.5rem;"></i>
                    <h4 style="margin: 0; font-size: 1.25rem;">Booking Berhasil!</h4>
                    <p style="color: var(--gray-600); font-size: 0.9rem;">ID Booking: <strong>${bookingId}</strong></p>
                </div>
                
                <div class="payment-qris-container" style="margin-bottom: 1rem;">
                    <img src="img/qris_dummy.svg" alt="QRIS Code" style="max-width: 200px; width: 100%; border: 1px solid var(--gray-200); border-radius: 0.5rem; padding: 10px;">
                </div>
                <div class="payment-amount" style="font-size: 1.5rem; font-weight: 700; color: var(--primary-color); margin-bottom: 1rem;">${formattedAmount}</div>

                <div class="payment-instructions" style="text-align: left; background: var(--gray-100); padding: 1rem; border-radius: 0.5rem; font-size: 0.85rem; margin-bottom: 1.5rem; line-height: 1.5;">
                    <strong>Cara Pembayaran:</strong>
                    <ol style="margin-left: 1.25rem; margin-top: 0.25rem;">
                        <li>Scan QRIS di atas menggunakan e-wallet (GoPay, OVO, Dana, dll) atau Mobile Banking.</li>
                        <li>Periksa nominal pembayaran.</li>
                        <li>Screenshot bukti pembayaran dan upload di bawah ini.</li>
                    </ol>
                </div>

                <form id="direct-payment-form" onsubmit="handleDirectPaymentSubmit(event, '${bookingId}')">
                    <div class="upload-area" onclick="document.getElementById('direct_proof_file').click()" style="border: 2px dashed var(--gray-300); padding: 1.5rem; border-radius: 0.5rem; cursor: pointer; text-align: center; margin-bottom: 1rem; transition: border-color 0.3s ease;">
                        <i class="fas fa-cloud-upload-alt upload-icon" style="font-size: 2rem; color: var(--gray-300); margin-bottom: 0.5rem;"></i>
                        <div class="upload-text" style="font-size: 0.9rem; color: var(--gray-600);">Klik untuk upload bukti pembayaran</div>
                        <input type="file" id="direct_proof_file" name="bukti_pembayaran" accept="image/*,application/pdf" style="display: none" onchange="previewDirectFile(this)" required>
                        <div class="file-preview" id="direct-file-preview" style="display: none; margin-top: 0.5rem;">
                            <img id="direct-preview-img" src="" style="max-height: 150px; margin: 0 auto; border-radius: 0.25rem;">
                            <p id="direct-filename" style="margin-top:0.5rem; font-size:0.8rem; color: var(--gray-600); font-weight: 500;"></p>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="button" class="btn btn-outline" onclick="closeModal()" style="flex: 1;">Bayar Nanti</button>
                        <button type="submit" class="btn btn-primary" style="flex: 2;">
                            <i class="fas fa-check-circle"></i> Konfirmasi Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        `;
        showModal('Pembayaran Booking', html);
    }

    function previewDirectFile(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('direct-file-preview');
                const img = document.getElementById('direct-preview-img');
                const text = document.querySelector('#direct-payment-form .upload-text');
                const icon = document.querySelector('#direct-payment-form .upload-icon');

                if (input.files[0].type.startsWith('image/')) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                } else {
                    img.style.display = 'none';
                }

                document.getElementById('direct-filename').textContent = input.files[0].name;
                preview.style.display = 'block';
                if (text) text.style.display = 'none';
                if (icon) icon.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    async function handleDirectPaymentSubmit(e, bookingId) {
        e.preventDefault();
        const form = e.target;
        const fileInput = document.getElementById('direct_proof_file');

        if (!fileInput.files.length) {
            alert('Mohon upload bukti pembayaran');
            return;
        }

        const formData = new FormData();
        formData.append('id_booking', bookingId);
        formData.append('bukti_pembayaran', fileInput.files[0]);

        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="loading"></span> Mengupload...';
        btn.disabled = true;

        try {
            const response = await fetch(window.APP_URL + '/api/bookings/upload-proof', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                showModal('Sukses', `
                    <div style="text-align:center; padding: 1rem;">
                        <i class="fas fa-check-circle" style="font-size: 4rem; color: #10b981; margin-bottom: 1rem;"></i>
                        <h3>Pembayaran Berhasil Dikirim!</h3>
                        <p style="margin-top: 0.5rem; color: var(--gray-600);">Terima kasih! Admin akan segera memverifikasi pembayaran Anda.</p>
                        <a href="{{ route('history') }}" class="btn btn-primary" style="margin-top: 1.5rem;">Lihat Riwayat</a>
                        <button class="btn btn-outline" onclick="closeModal()" style="margin-top: 1.5rem; margin-left: 0.5rem;">Selesai</button>
                    </div>
                `);
            } else {
                alert('Gagal: ' + result.message);
            }
        } catch (err) {
            alert('Terjadi kesalahan saat upload.');
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }

    function closeModal() {
        const modal = document.getElementById('modal');
        if (modal) modal.classList.remove('active');
    }

    // Fungsi pilih studio dari card di atas
    function pilihStudioUntukBooking(idStudio) {
        const selectStudio = document.getElementById('studio');
        if (selectStudio) {
            selectStudio.value = idStudio;
            selectStudio.dispatchEvent(new Event('change'));
            setTimeout(() => {
                window.location.href = '#booking';
            }, 300);
        }
    }
</script>
@endpush