<?php
session_start();
include '../config/koneksi.php';

if(empty($_SESSION['role'])){
    die("Anda harus login terlebih dahulu.");
}

$id_surat = mysqli_real_escape_string($koneksi, $_REQUEST['id_surat']);

$query = mysqli_query($koneksi, "SELECT sm.*, ds.tujuan, ds.batas_waktu, ds.isi, ds.catatan, ds.sifat 
                                 FROM surat_masuk sm 
                                 LEFT JOIN disposisi_surat ds 
                                 ON sm.id_surat_masuk = ds.id_surat_masuk 
                                 WHERE sm.id_surat_masuk='$id_surat'");
$row = mysqli_fetch_assoc($query);

// Format tanggal
function formatTanggalIndo($tgl){
    $bulan = [
        "01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April",
        "05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus",
        "09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Desember"
    ];
    $y = substr($tgl,0,4);
    $m = substr($tgl,5,2);
    $d = substr($tgl,8,2);
    return $d." ".$bulan[$m]." ".$y;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Lembar Disposisi</title>
    <style>
        body { font-size: 12px; color: #212121; }
        table { width: 100%; border-collapse: collapse; }
        td { border: 1px solid #444; padding: 5px; vertical-align: top; }
        .tgh { text-align: center; }
        .lead { font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body onload="window.print()">
    <h3 class="tgh">LEMBAR DISPOSISI</h3>
    <table>
        <tr>
            <td width="20%">Indeks Berkas</td>
            <td width="55%">: <?= $row['indeks_berkas'] ?></td>
            <td width="25%">Kode : <?= $row['kode'] ?></td>
        </tr>
        <tr>
            <td>Tanggal Surat</td>
            <td colspan="2">: <?= formatTanggalIndo($row['tanggal_masuk']) ?></td>
        </tr>
        <tr>
            <td>Nomor Surat</td>
            <td colspan="2">: <?= $row['nomor_surat'] ?></td>
        </tr>
        <tr>
            <td>Asal Surat</td>
            <td colspan="2">: <?= $row['pengirim'] ?></td>
        </tr>
        <tr>
            <td>Isi Ringkas</td>
            <td colspan="2">: <?= $row['perihal'] ?></td>
        </tr>
        <tr>
            <td>Diterima Tanggal</td>
            <td>: <?= formatTanggalIndo($row['tanggal_masuk']) ?></td>
            <td>No. Agenda : <?= $row['no_agenda'] ?></td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td colspan="2">: <?= $row['file_lampiran'] ? $row['file_lampiran'] : "-" ?></td>
        </tr>
        <tr>
            <td colspan="2">
                <strong>Isi Disposisi :</strong><br>
                <?= $row['isi'] ?: "-" ?><br><br>
                <strong>Batas Waktu :</strong> <?= $row['batas_waktu'] ? formatTanggalIndo($row['batas_waktu']) : "-" ?><br>
                <strong>Sifat :</strong> <?= $row['sifat'] ?: "-" ?><br>
                <strong>Catatan :</strong><br><?= $row['catatan'] ?: "-" ?>
            </td>
            <td>
                <strong>Diteruskan Kepada :</strong><br>
                <?= $row['tujuan'] ?: "-" ?>
            </td>
        </tr>
    </table>
    <br><br>
    <div style="text-align:right;">
        <p>Kepala Dinas</p>
        <br><br><br>
        <p class="lead">Nama Kepala Dinas</p>
        <p>NIP. 123456789</p>
    </div>
</body>
</html>
