<?php
include "functions.php";
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

$id = $_GET['id'] ?? 0;
$result = $conn->query("SELECT * FROM arsip_digital WHERE id=$id");
$data = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Detail Arsip</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow-lg">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Detail Arsip</h4>
    </div>
    <div class="card-body">
      <p><strong>Nama Kegiatan:</strong> <?= htmlspecialchars($data['nama_kegiatan']) ?></p>
      <p><strong>Kategori:</strong> <?= htmlspecialchars($data['kategori']) ?></p>
      <p><strong>Unit:</strong> <?= htmlspecialchars($data['unit']) ?></p>
      <p><strong>Waktu Pelaksanaan:</strong> <?= htmlspecialchars($data['waktu_pelaksanaan']) ?></p>
      <p><strong>Upload:</strong> <?= htmlspecialchars($data['uploaded_at']) ?></p>

      <div class="mt-3 text-center">
        <?php
        $file = $data['sampul'];
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
            echo "<img src='$file' class='img-fluid rounded border' style='max-height:400px;'>";
        } elseif (in_array($ext, ['mp4','webm','ogg'])) {
            // pastikan path sesuai dengan yang digunakan di list
            echo "<video controls class='rounded border' style='max-width:100%; max-height:400px;'>
                    <source src='$file' type='video/$ext'>
                    Browser anda tidak mendukung pemutaran video.
                  </video>";
        } else {
            echo "<a href='$file' target='_blank' class='btn btn-outline-primary'>Unduh File</a>";
        }
        ?>
      </div>
    </div>
    <div class="card-footer text-end">
      <a href="arsip.php?unit=<?= urlencode($data['unit']) ?>" class="btn btn-secondary">
        ← Kembali
      </a>
    </div>
  </div>
</div>
</body>
</html>
