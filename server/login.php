<?php
include "config.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Ambil data JSON dari frontend
$data = json_decode(file_get_contents("php://input"), true);

// Pastikan data dikirim dengan lengkap
if (!isset($data['nama']) || !isset($data['password'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Nama dan password wajib diisi"
    ]);
    exit;
}

$nama = mysqli_real_escape_string($conn, $data['nama']);
$password = mysqli_real_escape_string($conn, $data['password']);

// Query untuk mencari user berdasarkan nama dan password
$query = "SELECT * FROM users WHERE nama='$nama' AND password='$password'";
$result = mysqli_query($conn, $query);

// Cek apakah user ditemukan
if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    echo json_encode([
        "status" => "success",
        "message" => "Login berhasil",
        "user" => $user
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Nama atau password salah"
    ]);
}
?>
