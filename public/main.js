/**
 * StudioMusik Jjenaissante - Cleaned Main JS
 */

// Global variables
let currentUser = null;
let studiosData = [];

document.addEventListener('DOMContentLoaded', function() {
    // 1. Inisialisasi Navigasi & UI Umum
    initializeNavigation();
    initializeModals();
    
    // 2. Cek Status Login (Background)
    checkAuthStatus();
    
    // 3. Load Data Studio (Hanya jika ada kontainer studionya)
    if (document.getElementById('studios-grid')) {
        loadStudios();
    }

    // 4. Booking Form logic
    const bookingForm = document.getElementById('booking-form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', handleBookingSubmit);
    }

    const studioSelect = document.getElementById('studio');
    if (studioSelect) {
        studioSelect.addEventListener('change', populateRoomDropdown);
    }
});

// ============================
// 1. AUTHENTICATION & UI
// ============================

async function checkAuthStatus() {
    try {
        const response = await fetch('/api/me');
        const result = await response.json();
        
        if (result.success) {
            currentUser = result.user;
            updateAuthSection();
            // Isi form otomatis jika sedang di halaman booking
            if(document.getElementById('nama')) document.getElementById('nama').value = currentUser.nama_user;
        }
    } catch (error) {
        console.log('User status: Guest');
    }
}

function updateAuthSection() {
    const authSection = document.getElementById('auth-section');
    if (!authSection || !currentUser) return;
    
    authSection.innerHTML = `
        <div style="display: flex; align-items: center; gap: 10px;">
            <a href="/profile" class="nav-link"><i class="fas fa-user-circle"></i> ${currentUser.nama_user}</a>
            <a href="#" onclick="handleLogout()" style="color: var(--danger-color); font-size: 1.2rem;">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    `;
}

async function handleLogout() {
    if (confirm('Apakah Anda yakin ingin logout?')) {
        try {
            const response = await fetch('/auth/logout', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            window.location.href = '/login';
        } catch (error) {
            console.error('Logout failed:', error);
        }
    }
}

// ============================
// 2. DATA LOADING (STUDIO)
// ============================

async function loadStudios() {
    try {
        const response = await fetch('/api/studios');
        const result = await response.json();
        if (result.success) {
            studiosData = result.data;
            renderStudios();
            populateStudioDropdown();
        }
    } catch (error) {
        console.error('Gagal memuat studio:', error);
    }
}

function renderStudios() {
    const grid = document.getElementById('studios-grid');
    if (!grid) return;
    grid.innerHTML = '';

    const defaultImages = ['img/studio1.png', 'img/studio2.png', 'img/studio3.png'];

    studiosData.forEach((studio, index) => {
        const card = document.createElement('div');
        card.className = 'card studio-card';
        
        const imageSrc = studio.foto ? `img/${studio.foto}` : defaultImages[index % defaultImages.length];

        card.innerHTML = `
            <div class="studio-image" style="height: 200px; overflow: hidden;">
                <img src="${imageSrc}" alt="${studio.nama_studio}" 
                     style="width: 100%; height: 100%; object-fit: cover;"
                     onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
            </div>
            <div class="card-body">
                <h3 class="card-title">${studio.nama_studio}</h3>
                <p class="card-text"><i class="fas fa-map-marker-alt" style="color: var(--danger-color);"></i> ${studio.alamat}</p>
                <button onclick="pilihStudioUntukBooking('${studio.id_studio}')" class="btn btn-primary btn-block">
                    Pilih Studio
                </button>
            </div>
        `;
        grid.appendChild(card);
    });
}

function populateStudioDropdown() {
    const select = document.getElementById('studio');
    if (!select) return;

    // Clear existing options except first
    while (select.options.length > 1) {
        select.remove(1);
    }

    studiosData.forEach(studio => {
        const option = document.createElement('option');
        option.value = studio.id_studio;
        option.textContent = studio.nama_studio;
        select.appendChild(option);
    });
}

function populateRoomDropdown() {
    const studioId = document.getElementById('studio').value;
    const roomSelect = document.getElementById('ruangan');
    if (!roomSelect) return;

    // Clear existing
    while (roomSelect.options.length > 1) {
        roomSelect.remove(1);
    }

    if (!studioId) return;

    const studio = studiosData.find(s => s.id_studio === studioId);
    if (studio && studio.ruangan) {
        studio.ruangan.forEach(room => {
            const option = document.createElement('option');
            option.value = room.id_ruangan;
            option.textContent = `${room.nama_ruangan} - Rp ${parseInt(room.tarif_per_jam).toLocaleString('id-ID')}/jam`;
            roomSelect.appendChild(option);
        });
    }
}

// Fungsi tambahan agar saat klik "Pilih Studio", dropdown di form otomatis terisi
function pilihStudioUntukBooking(idStudio) {
    const selectStudio = document.getElementById('studio');
    if (selectStudio) {
        selectStudio.value = idStudio;
        // Trigger event change manual agar dropdown ruangan ikut update
        populateRoomDropdown();
        window.location.href = '#booking';
    }
}

// ============================
// 3. BOOKING SUBMISSION
// ============================

async function handleBookingSubmit(e) {
    e.preventDefault();

    if (!currentUser) {
        showModal('Login Diperlukan', '<p>Anda harus login terlebih dahulu untuk melakukan booking.</p><br><a href="/login" class="btn btn-primary">Ke Halaman Login</a>');
        return;
    }

    const formData = {
        id_user: currentUser.id_user,
        id_ruangan: document.getElementById('ruangan').value,
        tanggal_booking: document.getElementById('tanggal').value,
        jam_mulai: document.getElementById('jam_mulai').value,
        durasi: document.getElementById('durasi').value,
        catatan: ''
    };

    try {
        const response = await fetch('/api/booking', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formData)
        });

        const result = await response.json();

        if (result.success) {
            showModal('Sukses!', `<p>Booking berhasil dibuat! ID Booking: <strong>${result.data.id_booking}</strong></p><p>Silakan lakukan pembayaran di menu Riwayat.</p><br><a href="/history" class="btn btn-primary">Lihat Riwayat</a>`);
            document.getElementById('booking-form').reset();
        } else {
            showModal('Gagal', `<p>${result.message}</p>`);
        }
    } catch (error) {
        console.error('Booking error:', error);
        showModal('Error', '<p>Terjadi kesalahan sistem. Coba lagi nanti.</p>');
    }
}

// ============================
// 4. UI HELPERS (Nav & Modal)
// ============================

function initializeNavigation() {
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.getElementById('nav-menu');
    
    if (navToggle) {
        navToggle.addEventListener('click', () => navMenu.classList.toggle('active'));
    }
}

function initializeModals() {
    const modalClose = document.getElementById('modal-close');
    if (modalClose) {
        modalClose.addEventListener('click', () => {
            document.getElementById('modal').classList.remove('active');
        });
    }
}

function showModal(title, content) {
    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal-body').innerHTML = content;
    document.getElementById('modal').classList.add('active');
}

console.log('Main JS Laravel Berhasil Dimuat!');