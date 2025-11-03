<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$koneksi = mysqli_connect("localhost", "root", "", "dbionic");

if (!$koneksi) {
    echo json_encode(["status" => "error", "message" => "Koneksi ke database gagal"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$id = isset($data['id']) ? intval($data['id']) : 0;

if ($id > 0) {
    $hapus = mysqli_query($koneksi, "DELETE FROM users WHERE id = $id");
    if ($hapus) {
        echo json_encode(["status" => "success", "message" => "User berhasil dihapus"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal hapus user"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "ID tidak valid"]);
}
?>
