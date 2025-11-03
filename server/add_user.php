<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "config.php"; // koneksi ke database

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['nama'], $data['email'], $data['password'])) {
    $nama = $data['nama'];
    $email = $data['email'];
    $password = $data['password']; 

    $query = "INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$password')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => mysqli_error($conn)
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Data tidak lengkap"
    ]);
}
?>
