<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_arsip_dpppa"; // ganti sesuai nama database

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi ambil semua arsip per unit
function getArsipByUnit($unit, $order = 'ASC') {
    global $conn;
    $order = ($order === 'DESC') ? 'DESC' : 'ASC'; // biar aman
    return $conn->query("SELECT * FROM arsip_digital WHERE unit='$unit' ORDER BY id $order");
}

// Fungsi ambil arsip by id
function getArsipById($id) {
    global $conn;
    $sql = "SELECT * FROM arsip_digital WHERE id = $id";
    return $conn->query($sql)->fetch_assoc();
}
?>
