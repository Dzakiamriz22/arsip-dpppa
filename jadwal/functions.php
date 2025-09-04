<?php
// jadwal/functions.php

function getAllJadwal($koneksi, $tanggal) {
    $result = $koneksi->query("SELECT * FROM jadwal WHERE tanggal='$tanggal' ORDER BY waktu ASC");
    return $result;
}

function tambahJadwal($koneksi, $tanggal, $waktu, $tempat, $kegiatan, $pengirim, $disposisi) {
    $koneksi->query("INSERT INTO jadwal (tanggal, waktu, tempat, kegiatan, pengirim, disposisi) 
                     VALUES ('$tanggal','$waktu','$tempat','$kegiatan','$pengirim','$disposisi')");
}

function hapusJadwal($koneksi, $id) {
    $koneksi->query("DELETE FROM jadwal WHERE id=$id");
}

function getJadwalById($koneksi, $id) {
    return $koneksi->query("SELECT * FROM jadwal WHERE id=$id");
}

function updateJadwal($koneksi, $id, $tanggal, $waktu, $tempat, $kegiatan, $pengirim, $disposisi) {
    $koneksi->query("UPDATE jadwal SET 
                        tanggal='$tanggal',
                        waktu='$waktu',
                        tempat='$tempat',
                        kegiatan='$kegiatan',
                        pengirim='$pengirim',
                        disposisi='$disposisi'
                     WHERE id=$id");
}

// Format tanggal: Hari, DD Bulan YYYY
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
