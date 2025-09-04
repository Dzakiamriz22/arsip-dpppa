<?php
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

$search = '';
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
}

$query = "SELECT * FROM surat_keluar WHERE nomor_surat LIKE '%$search%' OR tujuan LIKE '%$search%' OR perihal LIKE '%$search%' ORDER BY tanggal_keluar DESC";
$result = mysqli_query($koneksi, $query);
?>

<div class="d-flex justify-content-between mb-3">
  <h4>Daftar Surat Keluar</h4>
  <?php if ($_SESSION['role'] == 'admin'): ?>
    <a href="add.php" class="btn btn-success">Tambah Surat</a>
  <?php endif; ?>
</div>

<form class="mb-3" method="get">
  <div class="input-group">
    <input type="text" name="search" class="form-control" placeholder="Cari surat..." value="<?= htmlspecialchars($search) ?>">
    <button class="btn btn-primary" type="submit">Cari</button>
  </div>
</form>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>No</th>
      <th>Nomor Surat</th>
      <th>Tanggal Keluar</th>
      <th>Tujuan</th>
      <th>Perihal</th>
      <th>Lampiran</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= $row['nomor_surat']; ?></td>
        <td><?= $row['tanggal_keluar']; ?></td>
        <td><?= $row['tujuan']; ?></td>
        <td><?= $row['perihal']; ?></td>
        <td>
            <?php if($row['file_lampiran']): ?>
                <a href="upload/<?= $row['file_lampiran'] ?>" target="_blank"><?= htmlspecialchars($row['file_lampiran']) ?></a>
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
        <td>
          <a href="detail.php?id=<?= $row['id_surat_keluar']; ?>" class="btn btn-sm btn-info">Detail</a>
          <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="edit.php?id=<?= $row['id_surat_keluar']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="delete.php?id=<?= $row['id_surat_keluar']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include '../templates/footer.php'; ?>
