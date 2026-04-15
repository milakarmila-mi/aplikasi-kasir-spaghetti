<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_kasir";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$username = "kasir1";
$password_plain = "rahasia";

// Hash password
$password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO kasir (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password_hash);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "User berhasil dibuat.";
} else {
    echo "Gagal membuat user.";
}
