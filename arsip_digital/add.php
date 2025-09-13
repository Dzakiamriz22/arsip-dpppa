<?php
include "functions.php";
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

$unit = $_GET['unit'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $namaKegiatan     = $_POST['nama_kegiatan'];
    $kategori         = $_POST['kategori'];
    $waktuPelaksanaan = $_POST['waktu_pelaksanaan'];

    $fileName = $_FILES['sampul']['name'];
    $tmpName  = $_FILES['sampul']['tmp_name'];
    $target   = "uploads/" . basename($fileName);

    if (move_uploaded_file($tmpName, $target)) {
        $sql = "INSERT INTO arsip_digital (unit, sampul, nama_kegiatan, kategori, waktu_pelaksanaan, uploaded_by) 
                VALUES ('$unit', '$target', '$namaKegiatan', '$kategori', '$waktuPelaksanaan', 1)";
        $conn->query($sql);
        header("Location: arsip.php?unit=" . urlencode($unit));
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Tambah Arsip</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Tambah Arsip - <?= htmlspecialchars($unit) ?></h4>
    </div>
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Sampul</label>
            <input type="file" name="sampul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" class="form-control" placeholder="Masukkan nama kegiatan" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <input type="text" name="kategori" class="form-control" value="Surat Menyurat DP3A" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Waktu Pelaksanaan</label>
            <input type="date" name="waktu_pelaksanaan" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="arsip.php?unit=<?= urlencode($unit) ?>" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</body>
</html>
