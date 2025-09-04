<?php
session_start();
if($_SESSION['role'] != 'admin'){
    echo "<div class='alert alert-danger'>Anda tidak memiliki akses ke halaman ini.</div>";
    include '../templates/footer.php';
    exit;
}

include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';
include 'functions.php';

$id = $_GET['id'];
$tanggal = $_GET['tanggal'] ?? date('Y-m-d');

$jadwalQuery = getJadwalById($koneksi, $id);
if(mysqli_num_rows($jadwalQuery)==0){
    echo "<div class='alert alert-danger'>Jadwal tidak ditemukan.</div>";
    include '../templates/footer.php';
    exit;
}
$row = mysqli_fetch_assoc($jadwalQuery);

if(isset($_POST['submit'])){
    $waktu = $_POST['waktu'];
    $tempat = $_POST['tempat'];
    $kegiatan = $_POST['kegiatan'];
    $pengirim = $_POST['pengirim'];
    $disposisi = $_POST['disposisi'];

    updateJadwal($koneksi, $id, $tanggal, $waktu, $tempat, $kegiatan, $pengirim, $disposisi);
    header("location:index.php?tanggal=$tanggal");
}
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header"><h4>Edit Jadwal</h4></div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Waktu</label>
                    <input type="time" class="form-control" name="waktu" value="<?= $row['waktu'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tempat</label>
                    <input type="text" class="form-control" name="tempat" value="<?= htmlspecialchars($row['tempat']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kegiatan</label>
                    <input type="text" class="form-control" name="kegiatan" value="<?= htmlspecialchars($row['kegiatan']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pengirim</label>
                    <input type="text" class="form-control" name="pengirim" value="<?= htmlspecialchars($row['pengirim']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Disposisi</label>
                    <input type="text" class="form-control" name="disposisi" value="<?= htmlspecialchars($row['disposisi']) ?>">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                <a href="index.php?tanggal=<?= $tanggal ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<?php include '../templates/footer.php'; ?>
