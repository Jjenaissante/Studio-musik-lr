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
});

// ============================
// 1. AUTHENTICATION & UI
// ============================

async function checkAuthStatus() {
    try {
        // Tetap arahkan ke api.php yang ada di folder public untuk sementara
        const response = await fetch('api.php?endpoint=me');
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
            <span class="nav-link"><i class="fas fa-user-circle"></i> ${currentUser.nama_user}</span>
            <a href="#" onclick="handleLogout()" style="color: var(--danger-color); font-size: 1.2rem;">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    `;
}

// ============================
// 2. DATA LOADING (STUDIO)
// ============================

async function loadStudios() {
    try {
        const response = await fetch('api.php?endpoint=studios');
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

// Fungsi tambahan agar saat klik "Pilih Studio", dropdown di form otomatis terisi
function pilihStudioUntukBooking(idStudio) {
    const selectStudio = document.getElementById('studio');
    if (selectStudio) {
        selectStudio.value = idStudio;
        // Trigger event change manual agar dropdown ruangan ikut update
        selectStudio.dispatchEvent(new Event('change'));
        window.location.href = '#booking';
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
    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal-body').innerHTML = content;
    document.getElementById('modal').classList.add('active');
}

console.log('Main JS Pangkas Berhasil Dimuat!');