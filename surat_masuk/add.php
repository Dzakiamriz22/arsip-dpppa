<?php
include '../templates/header.php';
include '../templates/navbar.php';

if ($_SESSION['role'] != 'admin') {
    echo "<div class='alert alert-danger'>Hanya admin yang bisa menambah surat.</div>";
    include '../templates/footer.php';
    exit;
}

if (isset($_POST['submit'])) {
    include '../config/koneksi.php';

    $nomor_surat = mysqli_real_escape_string($koneksi, $_POST['nomor_surat']);
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $pengirim = mysqli_real_escape_string($koneksi, $_POST['pengirim']);
    $perihal = mysqli_real_escape_string($koneksi, $_POST['perihal']);

    // Upload file lampiran
    $file_name = $_FILES['file_lampiran']['name'];
    $file_tmp = $_FILES['file_lampiran']['tmp_name'];
    $target_dir = "upload/";
    $target_file = $target_dir . basename($file_name);

    if (move_uploaded_file($file_tmp, $target_file)) {
        $insert = mysqli_query($koneksi, "INSERT INTO surat_masuk (nomor_surat, tanggal_masuk, pengirim, perihal, file_lampiran) VALUES ('$nomor_surat', '$tanggal_masuk', '$pengirim', '$perihal', '$file_name')");
        if ($insert) {
            echo "<div class='alert alert-success'>Surat masuk berhasil ditambahkan.</div>";
        } else {
            echo "<div class='alert alert-danger'>Gagal menambahkan surat.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Gagal mengunggah file lampiran.</div>";
    }
}
?>

<div class="card">
  <div class="card-header">
    <h4>Tambah Surat Masuk</h4>
  </div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Nomor Surat</label>
        <input type="text" class="form-control" name="nomor_surat" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Tanggal Masuk</label>
        <input type="date" class="form-control" name="tanggal_masuk" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Pengirim</label>
        <input type="text" class="form-control" name="pengirim" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Perihal</label>
        <textarea class="form-control" name="perihal" required></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Lampiran (PDF/DOC/JPG)</label>
        <input type="file" class="form-control" name="file_lampiran" required>
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
      <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</div>

<?php include '../templates/footer.php'; ?>
