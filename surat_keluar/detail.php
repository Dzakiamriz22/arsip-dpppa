<?php
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM surat_keluar WHERE id_surat_keluar='$id'");
$row = mysqli_fetch_assoc($query);

if (!$row) {
    echo "<div class='alert alert-danger'>Surat tidak ditemukan.</div>";
    include '../templates/footer.php';
    exit;
}
?>

<div class="card mb-3">
  <div class="card-header"><h4>Detail Surat Keluar</h4></div>
  <div class="card-body">
    <p><strong>Nomor Surat:</strong> <?= $row['nomor_surat']; ?></p>
    <p><strong>Tanggal Keluar:</strong> <?= $row['tanggal_keluar']; ?></p>
    <p><strong>Tujuan:</strong> <?= $row['tujuan']; ?></p>
    <p><strong>Perihal:</strong> <?= $row['perihal']; ?></p>
    <p><strong>Lampiran:</strong> 
        <?php if($row['file_lampiran']): ?>
            <a href="upload/<?= $row['file_lampiran'] ?>" target="_blank"><?= htmlspecialchars($row['file_lampiran']) ?></a>
        <?php else: ?>
            Tidak ada lampiran
        <?php endif; ?>
    </p>
  </div>
  <div class="card-footer">
    <a href="index.php" class="btn btn-secondary">Kembali</a>
    <?php if ($_SESSION['role'] == 'admin'): ?>
        <a href="edit.php?id=<?= $row['id_surat_keluar']; ?>" class="btn btn-warning">Edit</a>
        <a href="delete.php?id=<?= $row['id_surat_keluar']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
    <?php endif; ?>
  </div>
</div>

<?php include '../templates/footer.php'; ?>
