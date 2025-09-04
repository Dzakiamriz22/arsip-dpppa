<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "db_arsip_dpppa";

$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek Koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>