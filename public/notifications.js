/**
 * StudioMusik Jjenaissante - Notifications JS
 * Dibuat terpisah agar bisa dimuat di layout utama, kalender, dan riwayat.
 */

document.addEventListener('DOMContentLoaded', function() {
    if (window.sessionUser && window.sessionUser.logged_in && window.sessionUser.role === 'user') {
        initializeNotifications();
    }
});

function initializeNotifications() {
    const btn = document.getElementById('notification-btn');
    const dropdown = document.getElementById('notification-dropdown');
    const badge = document.getElementById('notification-badge');
    const list = document.getElementById('notification-list');
    const markAllBtn = document.getElementById('mark-all-read-btn');

    if (!btn || !dropdown) return;

    // Toggle dropdown
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('active');
        if (dropdown.classList.contains('active')) {
            loadNotifications();
        }
    });

    // Close dropdown on click outside
    document.addEventListener('click', function(e) {
        if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });

    // Mark all as read
    if (markAllBtn) {
        markAllBtn.addEventListener('click', async function(e) {
            e.stopPropagation();
            try {
                const response = await fetch((window.APP_URL || '') + '/api/notifications/mark-as-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const result = await response.json();
                if (result.success) {
                    loadNotifications();
                }
            } catch (error) {
                console.error('Gagal menandai dibaca:', error);
            }
        });
    }

    // Load initial unread count
    fetchUnreadCount();

    // Poll every 30 seconds for new notifications
    setInterval(fetchUnreadCount, 30000);

    async function fetchUnreadCount() {
        try {
            const response = await fetch((window.APP_URL || '') + '/api/notifications');
            const result = await response.json();
            if (result.success) {
                const unreadCount = result.unread_count;
                if (unreadCount > 0) {
                    badge.textContent = unreadCount;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            }
        } catch (error) {
            console.error('Gagal memuat count notifikasi:', error);
        }
    }

    async function loadNotifications() {
        list.innerHTML = '<div class="notification-loading">Memuat...</div>';
        try {
            const response = await fetch((window.APP_URL || '') + '/api/notifications');
            const result = await response.json();
            if (result.success) {
                const notifications = result.data;
                const unreadCount = result.unread_count;

                // Update badge
                if (unreadCount > 0) {
                    badge.textContent = unreadCount;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }

                if (notifications.length === 0) {
                    list.innerHTML = '<div class="no-notification">Tidak ada notifikasi</div>';
                    return;
                }

                list.innerHTML = '';
                notifications.forEach(n => {
                    const item = document.createElement('div');
                    item.className = `notification-item ${n.is_read ? '' : 'unread'}`;
                    
                    // Choose icon based on type
                    let iconClass = 'fa-info-circle';
                    if (n.tipe === 'booking_acc') iconClass = 'fa-check-circle';
                    else if (n.tipe === 'booking_created') iconClass = 'fa-calendar-plus';
                    else if (n.tipe === 'payment_pending') iconClass = 'fa-clock';
                    else if (n.tipe === 'booking_cancel' || n.tipe === 'booking_cancel_user') iconClass = 'fa-times-circle';
                    else if (n.tipe === 'booking_complete') iconClass = 'fa-calendar-check';

                    item.innerHTML = `
                        <div class="notification-icon-wrapper ${n.tipe || 'default'}">
                            <i class="fas ${iconClass}"></i>
                        </div>
                        <div class="notification-content-wrapper">
                            <div class="notification-title">${n.judul}</div>
                            <div class="notification-desc">${n.pesan}</div>
                            <div class="notification-time">${n.time_ago}</div>
                        </div>
                    `;

                    item.addEventListener('click', async function() {
                        if (!n.is_read) {
                            try {
                                await fetch((window.APP_URL || '') + '/api/notifications/mark-as-read', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({ id: n.id })
                                });
                            } catch (error) {
                                console.error('Gagal update read status:', error);
                            }
                        }
                        window.location.href = (window.APP_URL || '') + '/history';
                    });

                    list.appendChild(item);
                });
            }
        } catch (error) {
            list.innerHTML = '<div class="no-notification">Gagal memuat notifikasi.</div>';
            console.error('Gagal memuat notifikasi:', error);
        }
    }
}
