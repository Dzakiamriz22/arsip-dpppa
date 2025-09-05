<?php
include '../config/koneksi.php';
include 'functions.php';

// ambil tanggal dari parameter
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

if($tanggal == 'all'){
    $jadwalList = $koneksi->query("SELECT * FROM jadwal ORDER BY tanggal ASC, waktu ASC");
    $filterLabel = "Semua Jadwal";
} else {
    $jadwalList = getAllJadwal($koneksi, $tanggal);
    $filterLabel = formatTanggal($tanggal);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Jadwal</title>
    <style>
        body { font-family: "Times New Roman", serif; font-size: 14px; margin: 20px; }
        .print-title { text-align: center; font-size: 18pt; font-weight: bold; text-transform: uppercase; margin-bottom: 30px;}
        table { width: 100%; border-collapse: collapse; font-size: 12pt; }
        table th, table td { border: 1px solid black; padding: 6px; }
        thead tr {
            background-color: #e0e0e0 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;}
        th:nth-child(1), td:nth-child(1) { width: 5%; }   
        th:nth-child(2), td:nth-child(2) { width: 15%; }  
        th:nth-child(3), td:nth-child(3) { width: 8%; }  
        th:nth-child(4), td:nth-child(4) { width: 22%; }  
        th:nth-child(5), td:nth-child(5) { width: 30%; }  
        th:nth-child(6), td:nth-child(6) { width: 10%; }  
        th:nth-child(7), td:nth-child(7) { width: 10%; }  
        .print-note { margin-top: 15px; font-size: 10pt; font-style: italic; }
    </style>
</head>
<body onload="window.print()">

    <div class="print-title">
        JADWAL KEGIATAN DPPPA KOTA SEMARANG
        <br>
        <?= $filterLabel ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Tempat</th>
                <th>Kegiatan</th>
                <th>Pengirim</th>
                <th>Disposisi</th>
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
            </tr>
            <?php endwhile; ?>
            <?php if(mysqli_num_rows($jadwalList)==0): ?>
                <tr><td colspan="7" class="text-center">Belum ada jadwal.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="print-note">
        Note: Jika ada kegiatan yang belum terinput, mohon konfirmasi, terima kasih atas perhatiannya
    </div>

</body>
</html>
