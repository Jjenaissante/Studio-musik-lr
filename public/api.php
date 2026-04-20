<?php

// 1. SESSION HANDLING
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0, '/');
    session_start();
}

// 2. HEADERS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

// 3. DATABASE CONFIG
$db_config = [
    'host'     => '127.0.0.1',
    'user'     => 'root',
    'pass'     => '',
    'db_name'  => 'studio_musik',
    'port'     => 3306,
    'charset'  => 'utf8mb4'
];

$conn = new mysqli($db_config['host'], $db_config['user'], $db_config['pass'], $db_config['db_name'], $db_config['port']);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database Error: ' . $conn->connect_error]);
    exit;
}

// 4. HELPER FUNCTIONS
function clean_input($data) {
    global $conn;
    return $conn->real_escape_string(htmlspecialchars(stripslashes(trim($data))));
}

// 5. MAIN LOGIC (ROUTER)
$endpoint = $_GET['endpoint'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($endpoint) {
    
    // --- AUTH CHECK ---
    case 'me':
        if (isset($_SESSION['user_id'])) {
            echo json_encode([
                'success' => true, 
                'user' => [
                    'id_user' => $_SESSION['user_id'],
                    'role' => $_SESSION['role'] ?? 'user',
                    'nama_user' => $_SESSION['user_name'] ?? 'User'
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Not logged in']);
        }
        break;

    // --- DASHBOARD ADMIN ---
    case 'dashboard-stats':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']); exit;
        }

        $stats = [];
        $res = $conn->query("SELECT COUNT(*) as total FROM booking");
        $stats['total_bookings'] = $res->fetch_assoc()['total'];
        
        $res = $conn->query("SELECT COUNT(*) as confirmed FROM booking WHERE status_booking IN ('confirmed', 'completed')");
        $stats['confirmed_bookings'] = $res->fetch_assoc()['confirmed'];

        $res = $conn->query("SELECT COUNT(*) as pending FROM booking WHERE status_booking = 'pending'");
        $stats['pending_bookings'] = $res->fetch_assoc()['pending'];
        
        $res = $conn->query("SELECT SUM(d.total_bayar) as revenue FROM detail_booking d 
                             JOIN booking b ON d.id_booking = b.id_booking 
                             WHERE b.status_booking IN ('confirmed', 'completed')");
        $row = $res->fetch_assoc();
        $stats['total_revenue'] = $row['revenue'] ?? 0;

        echo json_encode(['success' => true, 'data' => $stats]);
        break;

    // --- LIST BOOKINGS (Admin & User) ---
    case 'bookings':
        $whereClause = "";
        
        // Filter User Biasa (Hanya lihat punya sendiri)
        if (isset($_GET['user_id'])) {
            $uid = clean_input($_GET['user_id']);
            $whereClause = "WHERE b.id_user = '$uid'";
        }
        // Filter Status
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $status = clean_input($_GET['status']);
            $whereClause .= ($whereClause ? " AND " : " WHERE ") . "b.status_booking = '$status'";
        }

        $sql = "SELECT b.*, u.nama_user, u.no_hp, s.nama_studio, r.nama_ruangan, d.total_bayar, d.status_pembayaran, d.bukti_pembayaran
                FROM booking b
                JOIN user u ON b.id_user = u.id_user
                JOIN ruangan r ON b.id_ruangan = r.id_ruangan
                JOIN studio s ON r.id_studio = s.id_studio
                LEFT JOIN detail_booking d ON b.id_booking = d.id_booking
                $whereClause
                ORDER BY b.tanggal_booking DESC, b.jam_mulai DESC";
        
        $result = $conn->query($sql);
        $data = [];
        if ($result) {
            while($row = $result->fetch_assoc()) $data[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $data]);
        break;

    // --- UPLOAD BUKTI TRANSFER ---
    case 'upload-proof':
        if ($method === 'POST') {
            if (!isset($_POST['id_booking']) || !isset($_FILES['bukti_pembayaran'])) {
                echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']); exit;
            }

            $id_booking = clean_input($_POST['id_booking']);
            $file = $_FILES['bukti_pembayaran'];

            // Validasi file
            $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) {
                echo json_encode(['success' => false, 'message' => 'Format file tidak didukung']); exit;
            }

            // Upload
            $filename = 'proof_' . $id_booking . '_' . time() . '.' . $ext;
            $target = 'bukti_pembayaran/' . $filename;

            if (move_uploaded_file($file['tmp_name'], $target)) {
                // Update detail_booking
                $sql = "UPDATE detail_booking SET bukti_pembayaran='$filename', status_pembayaran='waiting_verification' WHERE id_booking='$id_booking'";
                if ($conn->query($sql)) {
                    // Juga update status booking jika perlu (tapi booking tetap pending sampai admin confirm)
                    echo json_encode(['success' => true, 'message' => 'Bukti pembayaran berhasil diupload']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Database error']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal upload file']);
            }
        }
        break;

    // --- DATA STUDIO (Public) ---
    case 'studios':
        $id = isset($_GET['id']) ? clean_input($_GET['id']) : '';
        $where = $id ? "WHERE id_studio = '$id'" : "";
        
        $sql = "SELECT * FROM studio $where";
        $result = $conn->query($sql);
        $studios = [];
        
        while($studio = $result->fetch_assoc()) {
            $sid = $studio['id_studio'];
            $room_res = $conn->query("SELECT * FROM ruangan WHERE id_studio = '$sid'");
            $rooms = [];
            while($room = $room_res->fetch_assoc()) $rooms[] = $room;
            $studio['ruangan'] = $rooms;
            
            if ($id) {
                echo json_encode(['success' => true, 'data' => $studio]); // Return single object
                exit;
            }
            $studios[] = $studio;
        }
        echo json_encode(['success' => true, 'data' => $studios]);
        break;

    // --- BUAT BOOKING (User) ---
    case 'booking':
        if ($method === 'POST') {
            if (!isset($input['id_user']) || !isset($input['id_ruangan'])) {
                 echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']); exit;
            }

            $id_booking = 'BK' . substr(time(), -8); 
            $id_user = clean_input($input['id_user']);
            $id_ruangan = clean_input($input['id_ruangan']);
            $tgl = clean_input($input['tanggal_booking']);
            $jam = clean_input($input['jam_mulai']);
            $durasi = clean_input($input['durasi']);
            $catatan = isset($input['catatan']) ? clean_input($input['catatan']) : '';
            
            $jam_selesai = date('H:i', strtotime("$jam + $durasi hours"));
            
            // Validasi Double Booking
            $checkSql = "SELECT * FROM booking
                        WHERE id_ruangan = '$id_ruangan'
                        AND tanggal_booking = '$tgl'
                        AND status_booking != 'cancelled'
                        AND (
                            (jam_mulai < '$jam_selesai' AND jam_selesai > '$jam')
                        )";
            $checkRes = $conn->query($checkSql);
            if ($checkRes->num_rows > 0) {
                 echo json_encode(['success' => false, 'message' => 'Maaf, slot waktu ini sudah dibooking orang lain.']); exit;
            }

            $sql = "INSERT INTO booking (id_booking, id_user, id_ruangan, tanggal_booking, jam_mulai, jam_selesai, durasi, status_booking, catatan) 
                    VALUES ('$id_booking', '$id_user', '$id_ruangan', '$tgl', '$jam', '$jam_selesai', '$durasi', 'pending', '$catatan')";
            
            if ($conn->query($sql)) {
                $harga_res = $conn->query("SELECT tarif_per_jam FROM ruangan WHERE id_ruangan = '$id_ruangan'");
                $tarif = $harga_res->fetch_assoc()['tarif_per_jam'] ?? 0;
                $total_bayar = $tarif * $durasi;

                $conn->query("INSERT INTO detail_booking (id_booking, total_bayar, status_pembayaran) VALUES ('$id_booking', '$total_bayar', 'pending')");
                echo json_encode(['success' => true, 'data' => ['id_booking' => $id_booking]]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal menyimpan: ' . $conn->error]);
            }
        }
        break;

    // --- ADMIN: LIST USERS ---
    case 'users':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']); exit;
        }
        $result = $conn->query("SELECT id_user, nama_user, email, no_hp, role FROM user WHERE role = 'user'");
        $data = [];
        while($row = $result->fetch_assoc()) $data[] = $row;
        echo json_encode(['success' => true, 'data' => $data]);
        break;

    // --- ADMIN: RECENT BOOKINGS ---
    case 'recent-bookings':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']); exit;
        }
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
        $sql = "SELECT b.id_booking, u.nama_user, s.nama_studio, b.tanggal_booking, b.status_booking, d.total_bayar 
                FROM booking b
                JOIN user u ON b.id_user = u.id_user
                JOIN ruangan r ON b.id_ruangan = r.id_ruangan
                JOIN studio s ON r.id_studio = s.id_studio
                LEFT JOIN detail_booking d ON b.id_booking = d.id_booking
                ORDER BY b.tanggal_booking DESC, b.jam_mulai DESC LIMIT $limit";
        $result = $conn->query($sql);
        $data = [];
        while($row = $result->fetch_assoc()) $data[] = $row;
        echo json_encode(['success' => true, 'data' => $data]);
        break;

    // --- ADMIN: CONFIRM BOOKING ---
    case 'confirm-booking':
        if ($method === 'POST') {
            if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
                echo json_encode(['success' => false, 'message' => 'Unauthorized']); exit;
            }
            $id = clean_input($input['id_booking']);
            if($conn->query("UPDATE booking SET status_booking = 'confirmed' WHERE id_booking = '$id'")) {
                echo json_encode(['success' => true, 'message' => 'Booking dikonfirmasi']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal update database']);
            }
        }
        break;

    // --- ADMIN: CANCEL BOOKING ---
    case 'cancel-booking':
        if ($method === 'POST') {
            if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
                echo json_encode(['success' => false, 'message' => 'Unauthorized']); exit;
            }
            $id = clean_input($input['id_booking']);
            if($conn->query("UPDATE booking SET status_booking = 'cancelled' WHERE id_booking = '$id'")) {
                echo json_encode(['success' => true, 'message' => 'Booking dibatalkan']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal update database']);
            }
        }
        break;

        // --- UPDATE RUANGAN ---
    case 'update-room':
        if ($method === 'POST') {
            if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
                echo json_encode(['success' => false, 'message' => 'Unauthorized']); exit;
            }
            $id = clean_input($input['id_ruangan']);
            $nama = clean_input($input['nama_ruangan']);
            $kapasitas = clean_input($input['kapasitas']);
            $tarif = clean_input($input['tarif']);
            $status = clean_input($input['status']);

            $sql = "UPDATE ruangan SET nama_ruangan='$nama', kapasitas='$kapasitas', tarif_per_jam='$tarif', status='$status' WHERE id_ruangan='$id'";
            if ($conn->query($sql)) echo json_encode(['success' => true]);
            else echo json_encode(['success' => false, 'message' => $conn->error]);
        }
        break;

    // --- DELETE RUANGAN ---
    case 'delete-room':
        if ($method === 'POST') {
            if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
                echo json_encode(['success' => false, 'message' => 'Unauthorized']); exit;
            }
            $id = clean_input($input['id_ruangan']);
            $conn->query("DELETE FROM ruangan WHERE id_ruangan='$id'");
            if ($conn->affected_rows > 0) echo json_encode(['success' => true, 'message' => 'Terhapus']);
            else echo json_encode(['success' => false, 'message' => 'Gagal hapus']);
        }
        break;

    // --- UTILS ---
    case 'available-slots':
        $id_ruangan = isset($_GET['id_ruangan']) ? clean_input($_GET['id_ruangan']) : '';
        $date = isset($_GET['date']) ? clean_input($_GET['date']) : '';

        if (!$id_ruangan || !$date) {
             echo json_encode(['success' => false, 'message' => 'Missing params']); exit;
        }

        $sql = "SELECT jam_mulai, jam_selesai FROM booking
                WHERE id_ruangan = '$id_ruangan'
                AND tanggal_booking = '$date'
                AND status_booking != 'cancelled'";

        $result = $conn->query($sql);
        $booked_slots = [];

        while($row = $result->fetch_assoc()) {
            $booked_slots[] = [
                'start' => substr($row['jam_mulai'], 0, 5),
                'end' => substr($row['jam_selesai'], 0, 5),
                'available' => false
            ];
        }

        echo json_encode(['success' => true, 'data' => $booked_slots]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid endpoint']);
        break;
}
?>