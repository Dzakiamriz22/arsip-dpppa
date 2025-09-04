<?php
session_start();
if($_SESSION['role'] != 'admin'){
    echo "<div class='alert alert-danger'>Anda tidak memiliki akses ke halaman ini.</div>";
    include '../templates/footer.php';
    exit;
}

include '../config/koneksi.php';
include 'functions.php';

$id = $_GET['id'];
$tanggal = $_GET['tanggal'] ?? date('Y-m-d');

hapusJadwal($koneksi, $id);

header("location:index.php?tanggal=$tanggal");
?>
