<?php
include '../config/koneksi.php';
session_start();

if ($_SESSION['role'] != 'admin') {
    die("Hanya admin yang bisa menghapus.");
}

$id = $_GET['id'];

// Hapus file lampiran dari folder
$data = mysqli_query($koneksi, "SELECT file_lampiran FROM surat_masuk WHERE id_surat_masuk='$id'");
$row = mysqli_fetch_assoc($data);
if (file_exists("upload/".$row['file_lampiran'])) {
    unlink("upload/".$row['file_lampiran']);
}

// Hapus data dari database
mysqli_query($koneksi, "DELETE FROM surat_masuk WHERE id_surat_masuk='$id'");
header("location:index.php");
