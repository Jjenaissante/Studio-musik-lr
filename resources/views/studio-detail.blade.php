<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Studio - StudioMusik Jjenaissante</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #3730a3;
            --secondary-color: #f59e0b;
            --accent-color: #10b981;
            --danger-color: #ef4444;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
            --gray-900: #111827;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--gray-900);
            background: var(--gray-100);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--gray-200);
            z-index: 1000;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.25rem;
        }

        .nav-logo i {
            margin-right: 0.5rem;
            font-size: 1.5rem;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            align-items: center;
        }

        .nav-menu li {
            margin-left: 2rem;
        }

        .nav-link {
            text-decoration: none;
            color: var(--gray-600);
            font-weight: 500;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color);
        }

        .nav-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .nav-toggle span {
            width: 25px;
            height: 3px;
            background: var(--gray-600);
            margin: 3px 0;
            transition: 0.3s;
        }

        /* Studio Header */
        .studio-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 120px 0 60px;
            margin-top: 70px;
            text-align: center;
        }

        .studio-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .studio-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Studio Content */
        .studio-content {
            padding: 3rem 0;
        }

        .studio-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 3rem;
        }

        .studio-main-image {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4rem;
            margin-bottom: 2rem;
        }

        .studio-info {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow-md);
            padding: 2rem;
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .studio-info h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .studio-info p {
            color: var(--gray-600);
            margin-bottom: 1rem;
        }

        .studio-info .info-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            color: var(--gray-700);
        }

        .studio-info .info-item i {
            color: var(--primary-color);
            width: 20px;
        }

        .studio-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .stars {
            color: var(--secondary-color);
        }

        .rating-text {
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        /* Rooms Section */
        .rooms-section {
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: var(--gray-900);
        }

        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .room-card {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .room-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--accent-color), #059669);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }

        .room-info {
            padding: 1.5rem;
        }

        .room-name {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--gray-900);
        }

        .room-capacity {
            color: var(--gray-600);
            margin-bottom: 0.5rem;
        }

        .room-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .room-facilities {
            margin-bottom: 1.5rem;
        }

        .facility-tag {
            display: inline-block;
            background: var(--gray-100);
            color: var(--gray-700);
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        /* Reviews Section */
        .reviews-section {
            margin-bottom: 3rem;
        }

        .review-card {
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow-md);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .review-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .review-avatar {
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .review-info h4 {
            margin-bottom: 0.25rem;
        }

        .review-stars {
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .review-text {
            color: var(--gray-600);
            line-height: 1.6;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            width: 100%;
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 1rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--gray-600);
        }

        .modal-body {
            padding: 1.5rem;
        }

        /* Footer */
        .footer {
            background: var(--gray-900);
            color: white;
            padding: 3rem 0 1rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .footer-section p {
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }

        .footer-section a {
            color: #9ca3af;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: var(--primary-color);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #374151;
            color: #6b7280;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .studio-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .studio-info {
                position: static;
            }

            .rooms-grid {
                grid-template-columns: 1fr;
            }

            .nav-menu {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 70px);
                background: white;
                flex-direction: column;
                justify-content: flex-start;
                align-items: center;
                transition: 0.3s;
                box-shadow: var(--shadow-lg);
                padding-top: 2rem;
            }

            .nav-menu.active {
                left: 0;
            }

            .nav-toggle {
                display: flex;
            }
        }

        /* Utility Classes */
        .flex {
            display: flex;
        }

        .flex-between {
            justify-content: space-between;
        }

        .flex-center {
            justify-content: center;
        }

        .flex-items-center {
            align-items: center;
        }

        .text-center {
            text-align: center;
        }

        .mt-1 { margin-top: 1rem; }
        .mt-2 { margin-top: 2rem; }
        .mb-1 { margin-bottom: 1rem; }
        .mb-2 { margin-bottom: 2rem; }
        .p-0 { padding: 0; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="index.html" class="nav-logo">
                <i class="fas fa-music"></i>
                <span>StudioMusik Jjenaissante</span>
            </a>
            
            <ul class="nav-menu" id="nav-menu">
                <li><a href="index.html" class="nav-link">Beranda</a></li>
                <li><a href="index.html#studios" class="nav-link">Studio</a></li>
                <li><a href="calendar.html" class="nav-link">Kalender</a></li>
                <li><a href="index.html#booking" class="nav-link">Booking</a></li>
                <li><a href="index.html#about" class="nav-link">Tentang</a></li>
                <li id="auth-section">
                    <a href="login.html" class="nav-link" id="login-btn" style="background: var(--primary-color); color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; margin-left: 1rem;">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </li>
            </ul>
            
            <div class="nav-toggle" id="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Studio Header -->
    <section class="studio-header">
        <div class="container">
            <h1 id="studio-name">Loading...</h1>
            <p id="studio-address">Loading...</p>
        </div>
    </section>

    <!-- Studio Content -->
    <section class="studio-content">
        <div class="container">
            <div class="studio-grid">
                <!-- Main Content -->
                <div>
                    <div class="studio-main-image">
                        <i class="fas fa-building"></i>
                    </div>
                    
                    <!-- Rooms Section -->
                    <div class="rooms-section">
                        <h2 class="section-title">Ruangan Tersedia</h2>
                        <div class="rooms-grid" id="rooms-grid">
                            <!-- Rooms will be loaded here -->
                        </div>
                    </div>
                    
                    <!-- Reviews Section -->
                    <div class="reviews-section">
                        <h2 class="section-title">Ulasan Pelanggan</h2>
                        <div id="reviews-container">
                            <!-- Reviews will be loaded here -->
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="studio-info">
                    <h3>Informasi Studio</h3>
                    <p id="studio-description">Loading...</p>
                    
                    <div class="studio-rating" id="studio-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="rating-text">(0 ulasan)</span>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span id="studio-location">Loading...</span>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <span id="studio-phone">Loading...</span>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <span id="studio-email">Loading...</span>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span id="studio-hours">Loading...</span>
                    </div>
                    
                    <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--gray-200);">
                        <button class="btn btn-primary" onclick="window.location.href='index.html#booking'">
                            <i class="fas fa-calendar-check"></i> Booking Sekarang
                        </button>
                        <button class="btn btn-outline" onclick="window.location.href='calendar.html'" style="margin-top: 0.5rem;">
                            <i class="fas fa-calendar-alt"></i> Lihat Kalender
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>StudioMusik Jjenaissante</h3>
                    <p>Platform booking studio musik online yang memudahkan Anda dalam menyewa studio musik profesional dengan fasilitas lengkap.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Layanan</h3>
                    <a href="#">Recording Studio</a>
                    <a href="#">Practice Room</a>
                    <a href="#">Mixing & Mastering</a>
                    <a href="#">Rental Alat Musik</a>
                </div>
                
                <div class="footer-section">
                    <h3>Kontak</h3>
                    <p><i class="fas fa-phone"></i> +62 812-3456-7890</p>
                    <p><i class="fas fa-envelope"></i> info@studiomusik.com</p>
                    <p><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2026 StudioMusik. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Modal -->
    <div class="modal" id="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title">Modal Title</h3>
                <button class="modal-close" id="modal-close">&times;</button>
            </div>
            <div class="modal-body" id="modal-body">
                <!-- Modal content will be inserted here -->
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let studioData = null;
        let currentUser = null;

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            checkAuthStatus();
            loadStudioData();
            setupEventListeners();
        });

        // Check authentication status
        async function checkAuthStatus() {
            try {
                const response = await fetch('api.php?endpoint=me');
                const result = await response.json();
                
                if (result.success) {
                    currentUser = result.user;
                    updateAuthSection();
                }
            } catch (error) {
                console.log('User not logged in');
            }
        }

        // Update auth section
        function updateAuthSection() {
            const authSection = document.getElementById('auth-section');
            if (currentUser) {
                authSection.innerHTML = `
                    <div class="nav-link" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;" onclick="window.location.href='profile.html'">
                        <i class="fas fa-user-circle"></i>
                        <span>${currentUser.nama_user}</span>
                    </div>
                `;
            }
        }

        // Setup event listeners
        function setupEventListeners() {
            // Mobile menu toggle
            const navToggle = document.getElementById('nav-toggle');
            const navMenu = document.getElementById('nav-menu');
            
            if (navToggle && navMenu) {
                navToggle.addEventListener('click', function() {
                    navMenu.classList.toggle('active');
                });
            }

            // Modal close
            document.getElementById('modal-close').addEventListener('click', closeModal);
            document.getElementById('modal').addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });
        }

        // Load studio data
        async function loadStudioData() {
            // Get studio ID from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const studioId = urlParams.get('id') || 'S001';
            
            try {
                const response = await fetch(`api.php?endpoint=studio&id=${studioId}`);
                const result = await response.json();
                
                if (result.success) {
                    studioData = result.data;
                    displayStudioData(studioData);
                    loadReviews(studioId);
                } else {
                    showModal('Studio Tidak Ditemukan', '<p>Studio yang Anda cari tidak ditemukan.</p>');
                }
            } catch (error) {
                console.error('Error loading studio data:', error);
                showModal('Error', '<p>Gagal memuat data studio. Silakan coba lagi.</p>');
            }
        }

        // Display studio data
        function displayStudioData(studio) {
            // Update header
            document.getElementById('studio-name').textContent = studio.nama_studio;
            document.getElementById('studio-address').textContent = studio.alamat;
            
            // Update sidebar info
            document.getElementById('studio-description').textContent = 
                `${studio.nama_studio} adalah studio musik profesional dengan fasilitas lengkap untuk kebutuhan rekaman dan latihan musik Anda.`;
            document.getElementById('studio-location').textContent = studio.alamat;
            document.getElementById('studio-phone').textContent = studio.no_telp || 'Tidak tersedia';
            document.getElementById('studio-email').textContent = studio.email || 'Tidak tersedia';
            document.getElementById('studio-hours').textContent = 
                `${studio.jam_buka || '08:00'} - ${studio.jam_tutup || '22:00'} WIB`;
            
            // Display rooms
            displayRooms(studio.ruangan || []);
        }

        // Display rooms
        function displayRooms(rooms) {
            const roomsGrid = document.getElementById('rooms-grid');
            roomsGrid.innerHTML = '';
            
            if (rooms.length === 0) {
                roomsGrid.innerHTML = '<p style="grid-column: 1 / -1; text-align: center; color: var(--gray-600);">Tidak ada ruangan tersedia</p>';
                return;
            }
            
            rooms.forEach(room => {
                const roomCard = document.createElement('div');
                roomCard.className = 'room-card';
                
                // Parse facilities
                const facilities = room.fasilitas ? room.fasilitas.split(',') : [];
                const facilitiesHtml = facilities.slice(0, 4).map(facility => 
                    `<span class="facility-tag">${facility.trim()}</span>`
                ).join('');
                
                roomCard.innerHTML = `
                    <div class="room-image">
                        <i class="fas fa-music"></i>
                    </div>
                    <div class="room-info">
                        <h3 class="room-name">${room.nama_ruangan}</h3>
                        <p class="room-capacity">
                            <i class="fas fa-users"></i> Kapasitas: ${room.kapasitas} orang
                        </p>
                        <div class="room-price">${formatCurrency(room.tarif_per_jam)}/jam</div>
                        <div class="room-facilities">
                            ${facilitiesHtml}
                            ${facilities.length > 4 ? `<span class="facility-tag">+${facilities.length - 4} lainnya</span>` : ''}
                        </div>
                        <button class="btn btn-primary" onclick="bookRoom('${room.id_ruangan}')">
                            <i class="fas fa-calendar-check"></i> Booking Sekarang
                        </button>
                    </div>
                `;
                
                roomsGrid.appendChild(roomCard);
            });
        }

        // Load reviews
        async function loadReviews(studioId) {
            try {
                // For now, we'll show sample reviews
                // In a real implementation, this would fetch from the API
                const sampleReviews = [
                    {
                        nama_user: 'John Doe',
                        rating: 5,
                        komentar: 'Studio sangat bersih dan fasilitasnya lengkap. Suara rekaman juga bagus sekali. Recommended!',
                        created_at: '2026-01-05'
                    },
                    {
                        nama_user: 'Jane Smith',
                        rating: 4,
                        komentar: 'Pelayanan ramah, booking mudah, dan harga terjangkau. Tempatnya nyaman untuk latihan band.',
                        created_at: '2026-01-03'
                    },
                    {
                        nama_user: 'Mike Johnson',
                        rating: 5,
                        komentar: 'Sangat puas dengan hasil rekaman di sini. Engineer-nya profesional dan helpful.',
                        created_at: '2026-01-01'
                    }
                ];
                
                displayReviews(sampleReviews);
                updateRating(sampleReviews);
                
            } catch (error) {
                console.error('Error loading reviews:', error);
            }
        }

        // Display reviews
        function displayReviews(reviews) {
            const container = document.getElementById('reviews-container');
            container.innerHTML = '';
            
            if (reviews.length === 0) {
                container.innerHTML = '<p style="text-align: center; color: var(--gray-600);">Belum ada ulasan untuk studio ini</p>';
                return;
            }
            
            reviews.forEach(review => {
                const reviewCard = document.createElement('div');
                reviewCard.className = 'review-card';
                
                const stars = '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating);
                const initial = review.nama_user.charAt(0).toUpperCase();
                
                reviewCard.innerHTML = `
                    <div class="review-header">
                        <div class="review-avatar">${initial}</div>
                        <div class="review-info">
                            <h4>${review.nama_user}</h4>
                            <div class="review-stars">${stars}</div>
                            <small style="color: var(--gray-600);">${formatDate(review.created_at)}</small>
                        </div>
                    </div>
                    <div class="review-text">${review.komentar}</div>
                `;
                
                container.appendChild(reviewCard);
            });
        }

        // Update rating
        function updateRating(reviews) {
            if (reviews.length === 0) return;
            
            const avgRating = reviews.reduce((sum, review) => sum + review.rating, 0) / reviews.length;
            const fullStars = Math.floor(avgRating);
            const hasHalfStar = avgRating % 1 >= 0.5;
            
            const starsContainer = document.querySelector('.stars');
            starsContainer.innerHTML = '';
            
            // Full stars
            for (let i = 0; i < fullStars; i++) {
                starsContainer.innerHTML += '<i class="fas fa-star"></i>';
            }
            
            // Half star
            if (hasHalfStar) {
                starsContainer.innerHTML += '<i class="fas fa-star-half-alt"></i>';
            }
            
            // Empty stars
            const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
            for (let i = 0; i < emptyStars; i++) {
                starsContainer.innerHTML += '<i class="far fa-star"></i>';
            }
            
            // Update rating text
            document.querySelector('.rating-text').textContent = 
                `(${avgRating.toFixed(1)} dari ${reviews.length} ulasan)`;
        }

        // Book room
        function bookRoom(roomId) {
            if (!currentUser) {
                showModal('Login Diperlukan', `
                    <div class="text-center">
                        <i class="fas fa-sign-in-alt" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
                        <p>Silakan login terlebih dahulu untuk melakukan booking.</p>
                        <button class="btn btn-primary" onclick="window.location.href='login.html'">Login</button>
                        <button class="btn btn-outline" onclick="closeModal()" style="margin-left: 0.5rem;">Batal</button>
                    </div>
                `);
                return;
            }
            
            // Redirect to booking form with room pre-selected
            window.location.href = `index.html#booking?room=${roomId}`;
        }

        // Utility functions
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        function formatCurrency(amount) {
            return 'Rp ' + parseInt(amount).toLocaleString('id-ID');
        }

        function showModal(title, content) {
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-body').innerHTML = content;
            document.getElementById('modal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('modal').classList.remove('active');
        }
    </script>
</body>
</html>