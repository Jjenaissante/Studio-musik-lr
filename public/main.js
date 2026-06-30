/**
 * StudioMusik Jjenaissante - Main JS
 * Dioptimasi untuk Laravel routes
 */

// Global variables
let currentUser = null;
let studiosData = [];

document.addEventListener('DOMContentLoaded', function() {
    // 1. Inisialisasi Navigasi & UI Umum
    initializeNavigation();
    initializeModals();
    
    // 2. Cek auth dari session window (di-inject Blade)
    checkSessionUser();
    
    // 3. Load Data Studio (Hanya jika ada kontainer studionya)
    if (document.getElementById('studios-grid')) {
        loadStudios();
    }
});

// ============================
// 1. AUTHENTICATION & UI
// ============================

function checkSessionUser() {
    // Session di-inject oleh Blade ke window.sessionUser
    if (window.sessionUser && window.sessionUser.logged_in) {
        currentUser = window.sessionUser;
        // Isi form otomatis jika sedang di halaman booking
        if (document.getElementById('nama') && currentUser.user_name) {
            document.getElementById('nama').value = currentUser.user_name;
        }
        if (document.getElementById('email') && currentUser.user_email) {
            document.getElementById('email').value = currentUser.user_email;
        }
        if (document.getElementById('no_hp') && currentUser.user_no_hp) {
            document.getElementById('no_hp').value = currentUser.user_no_hp;
        }
    }
}

// ============================
// 2. DATA LOADING (STUDIO)
// ============================

async function loadStudios() {
    try {
        const response = await fetch((window.APP_URL || '') + '/api/studios');
        const result = await response.json();
        if (result.success) {
            studiosData = result.data;
            renderStudios();
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
        card.className = 'studio-card';
        
        const imageSrc = studio.foto ? `img/${studio.foto}` : defaultImages[index % defaultImages.length];

        // Format operational hours
        const formatTime = (timeStr) => {
            if (!timeStr) return '';
            return timeStr.substring(0, 5); // take HH:mm
        };
        const jamBuka = formatTime(studio.jam_buka) || '08:00';
        const jamTutup = formatTime(studio.jam_tutup) || '22:00';

        // Rooms list html
        let ruanganHtml = '';
        if (studio.ruangan && studio.ruangan.length > 0) {
            studio.ruangan.forEach(r => {
                const tarifFormatted = 'Rp ' + Number(r.tarif_per_jam).toLocaleString('id-ID');
                if (r.status === 'maintenance') {
                    ruanganHtml += `
                        <div class="ruangan-item-card" style="background: #fef3c7; border-left: 4px solid #f59e0b; opacity: 0.85;">
                            <div class="ruangan-info-left" style="text-align: left;">
                                <div class="ruangan-name-label" style="color: #92400e; font-weight: 600;">${r.nama_ruangan}</div>
                                <div class="ruangan-capacity-label" style="color: #b45309; font-weight: 500;">
                                    <i class="fas fa-tools"></i> Sedang Maintenance
                                </div>
                            </div>
                            <div class="ruangan-price-right" style="color: #b45309; font-weight: 700;">-</div>
                        </div>
                    `;
                } else {
                    ruanganHtml += `
                        <div class="ruangan-item-card">
                            <div class="ruangan-info-left">
                                <div class="ruangan-name-label">${r.nama_ruangan}</div>
                                <div class="ruangan-capacity-label">Kap: ${r.kapasitas} org</div>
                            </div>
                            <div class="ruangan-price-right">${tarifFormatted}</div>
                        </div>
                    `;
                }
            });
        } else {
            ruanganHtml = '<div style="text-align: center; color: var(--gray-600); font-size: 0.85rem; padding: 1rem 0;">Tidak ada ruangan tersedia.</div>';
        }

        card.innerHTML = `
            <div class="studio-image-container">
                <img src="${imageSrc}" alt="${studio.nama_studio}" 
                     onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
                <div class="studio-hours-pill">
                    <i class="far fa-clock"></i> ${jamBuka} - ${jamTutup}
                </div>
            </div>
            <div class="studio-card-body">
                <h3 class="studio-title-main">${studio.nama_studio}</h3>
                <div class="studio-address-row">
                    <i class="fas fa-map-marker-alt"></i> ${studio.alamat || '-'}
                </div>
                <div class="ruangan-list-container">
                    ${ruanganHtml}
                </div>
                <button onclick="pilihStudioUntukBooking('${studio.id_studio}')" class="btn-booking-action">
                    Booking Sekarang
                </button>
            </div>
        `;
        grid.appendChild(card);
    });
}

// Saat klik "Pilih Studio", dropdown di form otomatis terisi
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

// ============================
// 3. UI HELPERS (Nav & Modal)
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
    const modalEl = document.getElementById('modal');
    if (!modalEl) return;
    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal-body').innerHTML = content;
    modalEl.classList.add('active');
}

console.log('StudioMusik Laravel JS Loaded!');