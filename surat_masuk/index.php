<?php
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

$search = '';
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
}

$query = "SELECT * FROM surat_masuk 
          WHERE nomor_surat LIKE '%$search%' 
             OR pengirim LIKE '%$search%' 
             OR perihal LIKE '%$search%' 
          ORDER BY tanggal_masuk DESC";
$result = mysqli_query($koneksi, $query);

// Fungsi format tanggal
function formatTanggal($tanggal){
    $hariArray = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $bulanArray = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    $hari = $hariArray[date('w', strtotime($tanggal))];
    $tgl = date('d', strtotime($tanggal));
    $bulan = $bulanArray[date('n', strtotime($tanggal))];
    $tahun = date('Y', strtotime($tanggal));

    return "$hari, $tgl $bulan $tahun";
}
?>

<div class="d-flex justify-content-between mb-3">
  <h4>Daftar Surat Masuk</h4>
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
      <th>Tanggal Masuk</th>
      <th>Pengirim</th>
      <th>Perihal</th>
      <th>Lampiran</th>
      <?php if ($_SESSION['role'] == 'admin'): ?>
        <th>Aksi</th>
      <?php endif; ?>
    </tr>
  </thead>
  <tbody>
    <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= $row['nomor_surat']; ?></td>
        <td><?= formatTanggal($row['tanggal_masuk']); ?></td>
        <td><?= $row['pengirim']; ?></td>
        <td><?= $row['perihal']; ?></td>
        <td>
            <?php if($row['file_lampiran']): ?>
                <a href="upload/<?= $row['file_lampiran'] ?>" target="_blank"><?= htmlspecialchars($row['file_lampiran']) ?></a>
            <?php else: ?>
                -
            <?php endif; ?>
        </td>
        <?php if ($_SESSION['role'] == 'admin'): ?>
        <td>
          <a href="edit.php?id=<?= $row['id_surat_masuk']; ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="delete.php?id=<?= $row['id_surat_masuk']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
          <a href="detail.php?id=<?= $row['id_surat_masuk']; ?>" class="btn btn-sm btn-info">Detail</a>
          <a href="disposisi.php?id=<?= $row['id_surat_masuk']; ?>" class="btn btn-sm btn-primary">Disposisi</a>
          <a href="print.php?id_surat=<?= $row['id_surat_masuk']; ?>" target="_blank" class="btn btn-sm btn-secondary">Cetak</a>
        </td>
        <?php elseif($_SESSION['role'] != 'admin'): ?>
        <td>
          <a href="detail.php?id=<?= $row['id_surat_masuk']; ?>" class="btn btn-sm btn-info">Detail</a>
        </td>
        <?php endif; ?>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php include '../templates/footer.php'; ?>
