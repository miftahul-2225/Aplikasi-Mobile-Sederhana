<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

require_once "config.php";

// Fungsi untuk membaca input JSON
function getInput() {
    $data = file_get_contents("php://input");
    return json_decode($data, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // ===========================================================
    // 🟩 GET DATA
    // ===========================================================
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $stmt = $conn->prepare("SELECT id, nama, email, password FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                echo json_encode($result->fetch_assoc());
            } else {
                echo json_encode(["error" => "Data tidak ditemukan"]);
            }
        } else {
            $result = $conn->query("SELECT id, nama, email, password FROM users ORDER BY id DESC");
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode($data);
        }
        break;

    // ===========================================================
    // 🟦 INSERT DATA
    // ===========================================================
    case 'POST':
        $input = getInput();
        $nama = trim($input['nama'] ?? '');
        $email = trim($input['email'] ?? '');
        $password = trim($input['password'] ?? '');

        if (!empty($nama) && !empty($email) && !empty($password)) {
            // Hash password sebelum disimpan
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nama, $email, $hashedPassword);

            if ($stmt->execute()) {
                echo json_encode(["message" => "✅ Data berhasil ditambahkan"]);
            } else {
                echo json_encode(["error" => "❌ Gagal menambahkan data"]);
            }
        } else {
            echo json_encode(["error" => "Nama, Email, dan Password wajib diisi"]);
        }
        break;

    // ===========================================================
    // 🟨 UPDATE DATA
    // ===========================================================
    case 'PUT':
        if (!isset($_GET['id'])) {
            echo json_encode(["error" => "ID wajib disertakan"]);
            break;
        }

        $id = intval($_GET['id']);
        $input = getInput();
        $nama = trim($input['nama'] ?? '');
        $email = trim($input['email'] ?? '');
        $password = trim($input['password'] ?? '');

        if (!empty($nama) && !empty($email)) {
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET nama=?, email=?, password=? WHERE id=?");
                $stmt->bind_param("sssi", $nama, $email, $hashedPassword, $id);
            } else {
                $stmt = $conn->prepare("UPDATE users SET nama=?, email=? WHERE id=?");
                $stmt->bind_param("ssi", $nama, $email, $id);
            }

            if ($stmt->execute()) {
                echo json_encode(["message" => "✅ Data berhasil diupdate"]);
            } else {
                echo json_encode(["error" => "❌ Gagal memperbarui data"]);
            }
        } else {
            echo json_encode(["error" => "Nama dan Email wajib diisi"]);
        }
        break;

    // ===========================================================
    // 🟥 DELETE DATA
    // ===========================================================
    case 'DELETE':
        if (!isset($_GET['id'])) {
            echo json_encode(["error" => "ID wajib disertakan"]);
            break;
        }

        $id = intval($_GET['id']);
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "✅ Data berhasil dihapus"]);
        } else {
            echo json_encode(["error" => "❌ Gagal menghapus data"]);
        }
        break;

   
    default:
        echo json_encode(["error" => "Metode tidak didukung"]);
        break;
}

$conn->close();
?>
