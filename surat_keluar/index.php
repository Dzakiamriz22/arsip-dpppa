<?php
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

$search = '';
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
}

$query = "SELECT * FROM surat_keluar 
          WHERE nomor_surat LIKE '%$search%' 
             OR tujuan LIKE '%$search%' 
             OR perihal LIKE '%$search%' 
          ORDER BY tanggal_keluar DESC";
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

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold text-primary">📤 Daftar Surat Keluar</h4>
  <?php if ($_SESSION['role'] == 'admin'): ?>
    <a href="add.php" class="btn btn-success shadow-sm">
      <i class="fas fa-plus me-1"></i> Tambah Surat
    </a>
  <?php endif; ?>
</div>

<form class="mb-3" method="get">
  <div class="input-group shadow-sm">
    <input type="text" name="search" class="form-control" placeholder="Cari surat berdasarkan nomor, tujuan, atau perihal..." value="<?= htmlspecialchars($search) ?>">
    <button class="btn btn-danger fw-bold" type="submit">
      <i class="fas fa-search me-1"></i> Cari
    </button>
  </div>
</form>

<div class="table-responsive">
  <table class="table table-bordered table-striped align-middle shadow-sm">
    <thead class="text-white" style="background-color:#C8102E;">
      <tr class="text-center">
        <th style="width:50px;">No</th>
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
          <td class="text-center"><?= $no++; ?></td>
          <td><?= htmlspecialchars($row['nomor_surat']); ?></td>
          <td><?= formatTanggal($row['tanggal_keluar']); ?></td>
          <td><?= htmlspecialchars($row['tujuan']); ?></td>
          <td><?= htmlspecialchars($row['perihal']); ?></td>
          <td class="text-center">
              <?php if($row['file_lampiran']): ?>
                  <a href="upload/<?= $row['file_lampiran'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-file-alt"></i> Lihat
                  </a>
              <?php else: ?>
                  <span class="text-muted">-</span>
              <?php endif; ?>
          </td>
          <td class="text-center">
            <a href="detail.php?id=<?= $row['id_surat_keluar']; ?>" class="btn btn-sm btn-info text-white">
              <i class="fas fa-info-circle"></i>
            </a>
            <?php if ($_SESSION['role'] == 'admin'): ?>
              <a href="edit.php?id=<?= $row['id_surat_keluar']; ?>" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i>
              </a>
              <a href="delete.php?id=<?= $row['id_surat_keluar']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                <i class="fas fa-trash"></i>
              </a>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../templates/footer.php'; ?>
