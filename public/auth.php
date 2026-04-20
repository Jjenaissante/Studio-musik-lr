<?php

ob_start();
require_once 'config.php';

// Get input
$input = json_decode(file_get_contents('php://input'), true);
$action = $_GET['action'] ?? '';

// Set JSON header
header('Content-Type: application/json');

if ($action === 'login') {
    // Login process
    $email = isset($input['email']) ? clean_input($input['email']) : '';
    $password = isset($input['password']) ? $input['password'] : '';
    
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Email dan password wajib diisi!']);
        exit;
    }
    
    // Find user by email
    $query = "SELECT * FROM user WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        // Regenerasi ID sesi untuk keamanan
        session_regenerate_id(false);
        // Set session
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_name'] = $user['nama_user'];
        
        // PENTING: Paksa simpan sesi sebelum script berakhir
        session_write_close();
        
        // Send success response
        echo json_encode([
            'success' => true,
            'user' => [
                'id_user' => $user['id_user'],
                'name' => $user['nama_user'],
                'role' => $user['role'],
                'email' => $user['email']
            ]
        ]);

    } else {
        echo json_encode(['success' => false, 'message' => 'Email atau password salah!']);
    }
    
} elseif ($action === 'register') {
    // Registration process
    $name = clean_input($input['name'] ?? '');
    $email = clean_input($input['email'] ?? '');
    $raw_password = $input['password'] ?? '';
    
    if (empty($name) || empty($email) || empty($raw_password)) {
        echo json_encode(['success' => false, 'message' => 'Semua data wajib diisi!']);
        exit;
    }
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Format email tidak valid!']);
        exit;
    }
    
    // Validate password length
    if (strlen($raw_password) < 8) {
        echo json_encode(['success' => false, 'message' => 'Password minimal 8 karakter!']);
        exit;
    }
    
    // Hash password
    $password_hashed = password_hash($raw_password, PASSWORD_DEFAULT);
    $role = 'user';
    
    // Check if email already exists
    $check = $conn->prepare("SELECT id_user FROM user WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    
    if ($check->get_result()->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email sudah digunakan!']);
        exit;
    }
    
    // Insert new user
    $sql = "INSERT INTO user (nama_user, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $password_hashed, $role);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Registrasi berhasil!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal mendaftar: ' . $conn->error]);
    }
    
} elseif ($action === 'logout') {
    // Logout process
    session_destroy();
    echo json_encode(['success' => true, 'message' => 'Logout berhasil']);
    
} else {
    echo json_encode(['success' => false, 'message' => 'Aksi tidak valid!']);
}

ob_end_flush();
?>