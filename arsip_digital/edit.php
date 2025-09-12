<?php
include "functions.php";
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

$id = $_GET['id'] ?? 0;
$data = getArsipById($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $namaKegiatan = $_POST['nama_kegiatan'];
    $kategori     = $_POST['kategori'];
    $waktu        = $_POST['waktu_pelaksanaan'];

    // default tetap file lama
    $sampul = $data['sampul'];

    // jika ada file baru diupload
    if (!empty($_FILES['sampul']['name'])) {
        $targetDir = "uploads/"; // lokasi relatif dari folder script
        if (!is_dir("../" . $targetDir)) {
            mkdir("../" . $targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES["sampul"]["name"]);
        $targetFile = "../" . $targetDir . $fileName;

        if (move_uploaded_file($_FILES["sampul"]["tmp_name"], $targetFile)) {
            $sampul = $targetDir . $fileName;
        }
    }

    // update database
    $stmt = $conn->prepare("UPDATE arsip_digital 
        SET sampul=?, nama_kegiatan=?, kategori=?, waktu_pelaksanaan=? 
        WHERE id=?");
    $stmt->bind_param("ssssi", $sampul, $namaKegiatan, $kategori, $waktu, $id);
    $stmt->execute();

    header("Location: arsip.php?unit=" . urlencode($data['unit']));
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Arsip</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="card shadow">
    <div class="card-header bg-warning text-dark">
      <h4 class="mb-0">Edit Arsip - <?= htmlspecialchars($data['unit']) ?></h4>
    </div>
    <div class="card-body">
      <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Sampul</label><br>
          <?php if (!empty($data['sampul'])): ?>
            <div class="mb-2">
              <img src="<?= htmlspecialchars($data['sampul']) ?>" alt="sampul" style="max-width:120px; height:auto;">
            </div>
          <?php endif; ?>
          <input type="file" name="sampul" class="form-control">
          <small class="text-muted">Kosongkan jika tidak ingin mengganti</small>
        </div>

        <div class="mb-3">
          <label class="form-label">Nama Kegiatan</label>
          <input type="text" name="nama_kegiatan" value="<?= htmlspecialchars($data['nama_kegiatan']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Kategori</label>
          <input type="text" name="kategori" value="<?= htmlspecialchars($data['kategori']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Waktu Pelaksanaan</label>
          <input type="date" name="waktu_pelaksanaan" value="<?= htmlspecialchars($data['waktu_pelaksanaan']) ?>" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="arsip.php?unit=<?= urlencode($data['unit']) ?>" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</body>
</html>
