<?php
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

// Ambil ID surat dari URL
if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID surat tidak ditemukan.</div>";
    include '../templates/footer.php';
    exit;
}

$id = $_GET['id'];

// Ambil data surat
$query = mysqli_query($koneksi, "SELECT * FROM surat_masuk WHERE id_surat_masuk='$id'");
if(mysqli_num_rows($query) == 0){
    echo "<div class='alert alert-danger'>Surat tidak ditemukan.</div>";
    include '../templates/footer.php';
    exit;
}
$row = mysqli_fetch_assoc($query);

// Ambil disposisi jika ada
$dispQuery = mysqli_query($koneksi, "SELECT * FROM disposisi_surat WHERE id_surat_masuk='$id'");
$disp = mysqli_fetch_assoc($dispQuery);

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

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4>Detail Surat Masuk</h4>
        </div>
        <div class="card-body">
            <p><strong>Nomor Surat:</strong> <?= htmlspecialchars($row['nomor_surat']) ?></p>
            <p><strong>Tanggal Masuk:</strong> <?= formatTanggal($row['tanggal_masuk']) ?></p>
            <p><strong>Pengirim:</strong> <?= htmlspecialchars($row['pengirim']) ?></p>
            <p><strong>Perihal:</strong> <?= htmlspecialchars($row['perihal']) ?></p>
            <p><strong>Lampiran:</strong> 
                <?php if($row['file_lampiran']): ?>
                    <a href="upload/<?= $row['file_lampiran'] ?>" target="_blank"><?= htmlspecialchars($row['file_lampiran']) ?></a>
                <?php else: ?>
                    Tidak ada lampiran
                <?php endif; ?>
            </p>

            <hr>
            <h5>Disposisi</h5>
            <?php if($disp): ?>
                <p><strong>Tujuan:</strong> <?= htmlspecialchars($disp['tujuan']) ?></p>
                <p><strong>Batas Waktu:</strong> <?= formatTanggal($disp['batas_waktu']) ?></p>
                <p><strong>Isi:</strong> <?= htmlspecialchars($disp['isi']) ?></p>
                <p><strong>Catatan:</strong> <?= htmlspecialchars($disp['catatan']) ?></p>
                <p><strong>Sifat:</strong> <?= htmlspecialchars($disp['sifat']) ?></p>
            <?php else: ?>
                <p class="text-warning">Belum ada disposisi.</p>
            <?php endif; ?>
        </div>
        <div class="card-footer">
            <a href="index.php" class="btn btn-secondary">Kembali</a>
            <?php if ($_SESSION['role']=='admin'): ?>
                <a href="disposisi.php?id=<?= $row['id_surat_masuk'] ?>" class="btn btn-primary">Tambahkan/Edit Disposisi</a>
                <a href="edit.php?id=<?= $row['id_surat_masuk'] ?>" class="btn btn-warning">Edit Surat</a>
                <a href="delete.php?id=<?= $row['id_surat_masuk'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus Surat</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
