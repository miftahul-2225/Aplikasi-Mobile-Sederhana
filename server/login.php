<?php
include "config.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// TOKEN RAHASIA SERVER — ubah sesuai keinginan kamu
define("SECRET_TOKEN", "supertoken123");

// Ambil data JSON dari frontend
$data = json_decode(file_get_contents("php://input"), true);

// Pastikan data dikirim dengan lengkap
if (!isset($data['nama']) || !isset($data['password']) || !isset($data['token'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Nama, password, dan token wajib diisi"
    ]);
    exit;
}

$nama = mysqli_real_escape_string($conn, $data['nama']);
$password = mysqli_real_escape_string($conn, $data['password']);
$token = trim($data['token']);

// ✅ Cek apakah token yang dikirim cocok dengan token rahasia server
if ($token !== SECRET_TOKEN) {
    echo json_encode([
        "status" => "error",
        "message" => "Token tidak valid! Akses ditolak."
    ]);
    exit;
}

// Query untuk mencari user berdasarkan nama dan password
$query = "SELECT * FROM users WHERE nama='$nama' AND password='$password'";
$result = mysqli_query($conn, $query);

// Cek apakah user ditemukan
if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    // Buat session token unik untuk user yang login
    $session_token = base64_encode(random_bytes(16));

    echo json_encode([
        "status" => "success",
        "message" => "Login berhasil",
        "user" => [
            "id" => $user['id'],
            "nama" => $user['nama'],
            "session_token" => $session_token
        ]
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Nama atau password salah"
    ]);
}
?>
