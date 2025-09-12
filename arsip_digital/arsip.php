<?php
include "functions.php";
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

$unit = $_GET['unit'] ?? '';
$result = getArsipByUnit($unit, 'ASC');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Arsip <?= htmlspecialchars($unit) ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-4">
    <h2>Arsip <?= htmlspecialchars($unit) ?></h2>
    <a href="add.php?unit=<?= urlencode($unit) ?>" class="btn btn-success mb-3">+ Tambah Arsip</a>
    <table class="table table-bordered table-striped">
      <thead class="table-primary">
        <tr>
          <th>No</th> <!-- ganti jadi nomor urut -->
          <th>Sampul</th>
          <th>Nama Kegiatan</th>
          <th>Kategori</th>
          <th>Waktu Pelaksanaan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $no = 1; // counter manual untuk nomor urut
        while($row = $result->fetch_assoc()): 
        ?>
        <tr>
          <td><?= $no++ ?></td> <!-- nomor urut -->
          <td>
            <?php if (!empty($row['sampul'])): ?>
              <?php 
                $file = $row['sampul'];
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                    // jika gambar
                    echo "<img src='{$file}' alt='sampul' style='max-width:100px; height:auto;'>";
                } elseif (in_array($ext, ['mp4','webm','ogg'])) {
                    // jika video → tampil thumbnail default tanpa kontrol
                    echo "<a href='detail.php?id={$row['id']}'>
                            <video width='120' height='80' preload='metadata' muted>
                              <source src='{$file}#t=0.5' type='video/$ext'>
                            </video>
                          </a>";
                } else {
                    // file lain → link download
                    echo "<a href='{$file}' target='_blank'>Download File</a>";
                }
              ?>
            <?php else: ?>
              <span class="text-muted">Tidak ada</span>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>
          <td><?= htmlspecialchars($row['kategori']) ?></td>
          <td><?= htmlspecialchars($row['waktu_pelaksanaan']) ?></td>
          <td>
            <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">Detail</a>
            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
