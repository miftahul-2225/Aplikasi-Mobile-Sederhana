<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$koneksi = mysqli_connect("localhost", "root", "", "dbionic");

if (!$koneksi) {
    echo json_encode(["status" => "error", "message" => "Koneksi gagal"]);
    exit;
}

$query = mysqli_query($koneksi, "SELECT id, nama, email FROM users");

if ($query) {
    $users = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $users[] = $row;
    }
    echo json_encode(["status" => "success", "users" => $users]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal query data"]);
}
?>
