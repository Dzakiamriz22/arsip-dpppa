<?php
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

if ($_SESSION['role'] != 'admin') {
    echo "<div class='alert alert-danger'>Hanya admin yang bisa edit surat.</div>";
    include '../templates/footer.php';
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM surat_masuk WHERE id_surat_masuk='$id'");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['submit'])) {
    $nomor_surat = mysqli_real_escape_string($koneksi, $_POST['nomor_surat']);
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $pengirim = mysqli_real_escape_string($koneksi, $_POST['pengirim']);
    $perihal = mysqli_real_escape_string($koneksi, $_POST['perihal']);

    // Upload file baru jika ada
    if (!empty($_FILES['file_lampiran']['name'])) {
        $file_name = $_FILES['file_lampiran']['name'];
        $file_tmp = $_FILES['file_lampiran']['tmp_name'];
        $target_dir = "upload/";
        $target_file = $target_dir . basename($file_name);
        move_uploaded_file($file_tmp, $target_file);
    } else {
        $file_name = $row['file_lampiran']; // tetap pakai file lama
    }

    $update = mysqli_query($koneksi, "UPDATE surat_masuk SET nomor_surat='$nomor_surat', tanggal_masuk='$tanggal_masuk', pengirim='$pengirim', perihal='$perihal', file_lampiran='$file_name' WHERE id_surat_masuk='$id'");

    if ($update) {
        echo "<div class='alert alert-success'>Surat berhasil diperbarui.</div>";
        $row = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM surat_masuk WHERE id_surat_masuk='$id'"));
    } else {
        echo "<div class='alert alert-danger'>Gagal memperbarui surat.</div>";
    }
}
?>

<div class="card">
  <div class="card-header"><h4>Edit Surat Masuk</h4></div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Nomor Surat</label>
        <input type="text" class="form-control" name="nomor_surat" value="<?= $row['nomor_surat'] ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Tanggal Masuk</label>
        <input type="date" class="form-control" name="tanggal_masuk" value="<?= $row['tanggal_masuk'] ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Pengirim</label>
        <input type="text" class="form-control" name="pengirim" value="<?= $row['pengirim'] ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Perihal</label>
        <textarea class="form-control" name="perihal" required><?= $row['perihal'] ?></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Lampiran (PDF/DOC/JPG)</label>
        <input type="file" class="form-control" name="file_lampiran">
        <small>File lama: <?= $row['file_lampiran'] ?></small>
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Update</button>
      <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</div>

<?php include '../templates/footer.php'; ?>
