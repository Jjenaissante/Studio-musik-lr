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
});

// ============================
// 1. AUTHENTICATION & UI
// ============================

async function checkAuthStatus() {
    try {
        const response = await fetch('/me');
        const result = await response.json();
        
        if (result.success) {
            currentUser = result.user;
            updateAuthSection();
            // Isi form otomatis jika sedang di halaman booking
            if(document.getElementById('nama') && !document.getElementById('nama').value) document.getElementById('nama').value = currentUser.nama_user;
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
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        try {
            const response = await fetch('/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            const result = await response.json();
            if (result.success) {
                window.location.href = '/login';
            }
        } catch (error) {
            console.error('Logout error:', error);
        }
    }
}

// ============================
// 2. UI HELPERS (Nav & Modal)
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

console.log('Main JS Laravel Version Loaded!');
