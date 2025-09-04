<?php
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM jadwal WHERE id='$id'");
$row = mysqli_fetch_assoc($query);

if (!$row) {
    echo "<div class='alert alert-danger'>Jadwal tidak ditemukan.</div>";
    include '../templates/footer.php';
    exit;
}
?>

<div class="card">
  <div class="card-header"><h4>Detail Jadwal</h4></div>
  <div class="card-body">
    <p><strong>Tanggal:</strong> <?= $row['tanggal'] ?></p>
    <p><strong>Waktu:</strong> <?= $row['waktu'] ?></p>
    <p><strong>Tempat:</strong> <?= $row['tempat'] ?></p>
    <p><strong>Kegiatan:</strong> <?= $row['kegiatan'] ?></p>
    <p><strong>Pengirim:</strong> <?= $row['pengirim'] ?></p>
    <p><strong>Disposisi:</strong> <?= $row['disposisi'] ?></p>
  </div>
  <div class="card-footer">
    <a href="index.php" class="btn btn-secondary">Kembali</a>
    <?php if ($_SESSION['role']=='admin'): ?>
        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning">Edit</a>
        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
    <?php endif; ?>
  </div>
</div>

<?php include '../templates/footer.php'; ?>
