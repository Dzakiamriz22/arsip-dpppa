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

<style>
@media print {
    form,
    .btn,
    .d-flex,
    .input-group,
    .navbar,
    .navbar-brand,      /* sembunyikan logo/tulisan brand */
    header h1,          /* kalau ada judul besar di header */
    header h2 {
        display: none !important;
    }

    /* Atur layout khusus cetak */
    body {
        font-family: "Times New Roman", serif;
        font-size: 14px;
        margin: 20px;
    }

    /* Judul */
    .print-title {
        text-align: center;
        font-size: 18pt;
        font-weight: bold;
        text-transform: uppercase;
    }

    .print-subtitle {
        text-align: center;
        font-size: 14pt;
        font-weight: bold;
        margin-bottom: 20px;
    }

    table {
        width: 100% !important;
        border-collapse: collapse;
        font-size: 12pt;
    }

    table th, table td {
        border: 1px solid black;
        padding: 6px;
    }

    /* Note bawah tabel */
    .print-note {
        margin-top: 15px;
        font-size: 10pt;
        font-style: italic;
    }
}
</style>


<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h4>Jadwal Kegiatan - <?= $filterLabel ?></h4>
        <?php if($_SESSION['role']=='admin'): ?>
            <a href="add.php?tanggal=<?= ($tanggal=='all'?'':$tanggal) ?>" class="btn btn-success">Tambah Jadwal</a>
        <?php endif; ?>
    </div>

    <form method="get" class="mb-3">
        <div class="input-group">
            <!-- input tanggal langsung auto-submit saat berubah -->
            <input type="date" name="tanggal" class="form-control" 
               value="<?= ($tanggal=='all'?'':$tanggal) ?>" 
               onchange="this.form.submit()">

            <!-- tombol cetak untuk jadwal hari ini / tanggal terpilih -->
            <button type="button" class="btn btn-secondary" onclick="window.print()">Cetak</button>
        </div>
    </form>

    <div class="print-title d-none d-print-block">
        JADWAL KEGIATAN DPPPA KOTA SEMARANG
    </div>

    <div class="print-subtitle d-none d-print-block">
        <?= $filterLabel ?>
    </div>

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

    <div class="print-note d-none d-print-block">
        Note: Jika ada kegiatan yang belum terinput, mohon konfirmasi, terima kasih atas perhatiannya
    </div>

</div>

<?php include '../templates/footer.php'; ?>
