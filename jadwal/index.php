<?php
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';
include 'functions.php';

// Default hari ini
$tanggal = date('Y-m-d'); 
$filterLabel = "Hari Ini";

// Cek apakah user memilih filter
if(isset($_GET['tanggal'])){
    $tanggal = $_GET['tanggal'];
    if($tanggal == 'all'){
        $jadwalList = $koneksi->query("SELECT * FROM jadwal ORDER BY tanggal ASC, waktu ASC");
        $filterLabel = "Semua Jadwal";
    } else {
        $jadwalList = getAllJadwal($koneksi, $tanggal);
        $filterLabel = formatTanggal($tanggal);
    }
} else {
    $jadwalList = getAllJadwal($koneksi, $tanggal);
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h4>Jadwal Kegiatan - <?= $filterLabel ?></h4>
        <?php if($_SESSION['role']=='admin'): ?>
            <a href="add.php?tanggal=<?= ($tanggal=='all'?'':$tanggal) ?>" class="btn btn-success">Tambah Jadwal</a>
        <?php endif; ?>
    </div>

    <form method="get" class="mb-3">
        <div class="input-group">
            <input type="date" name="tanggal" class="form-control" 
               value="<?= ($tanggal=='all'?'':$tanggal) ?>" 
               onchange="this.form.submit()">

            <a href="print.php?tanggal=<?= $tanggal ?>" target="_blank" class="btn btn-secondary">Cetak</a>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Tempat</th>
                <th>Kegiatan</th>
                <th>Pengirim</th>
                <th>Disposisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($jadwalList)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= formatTanggal($row['tanggal']) ?></td>
                <td><?= $row['waktu'] ?></td>
                <td><?= htmlspecialchars($row['tempat']) ?></td>
                <td><?= htmlspecialchars($row['kegiatan']) ?></td>
                <td><?= htmlspecialchars($row['pengirim']) ?></td>
                <td><?= htmlspecialchars($row['disposisi']) ?></td>
                <td>
                    <?php if($_SESSION['role']=='admin'): ?>
                        <a href="edit.php?id=<?= $row['id'] ?>&tanggal=<?= ($tanggal=='all'?'':$tanggal) ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>&tanggal=<?= ($tanggal=='all'?'':$tanggal) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus jadwal ini?')">Hapus</a>
                    <?php else: ?>
                        <span class="text-muted">Tidak ada aksi</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
            <?php if(mysqli_num_rows($jadwalList)==0): ?>
                <tr><td colspan="8" class="text-center">Belum ada jadwal.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
