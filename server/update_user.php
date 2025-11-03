<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$koneksi = mysqli_connect("localhost", "root", "", "dbionic");

if (!$koneksi) {
    echo json_encode(["status" => "error", "message" => "Koneksi ke database gagal"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$id = isset($data['id']) ? intval($data['id']) : 0;
$nama = $data['nama'] ?? '';
$email = $data['email'] ?? '';

if ($id > 0 && $nama && $email) {
    $update = mysqli_query($koneksi, "UPDATE users SET nama='$nama', email='$email' WHERE id=$id");
    if ($update) {
        echo json_encode(["status" => "success", "message" => "User berhasil diupdate"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal update user"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Data tidak lengkap"]);
}
?>
