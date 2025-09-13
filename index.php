<?php
include 'templates/header.php';
include 'templates/navbar.php';
include 'config/koneksi.php';

// Ambil info user
$namaUser = $_SESSION['nama_lengkap'];
$roleUser = $_SESSION['role'];

// Ambil jumlah data
$suratMasuk   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM surat_masuk"))['total'];
$suratKeluar  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM surat_keluar"))['total'];
$disposisi    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM disposisi_surat"))['total'];
$userCount    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM users"))['total'];

// Jumlah surat & jadwal hari ini
$today = date('Y-m-d');
$suratHariIni  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM surat_masuk WHERE tanggal_masuk='$today'"))['total'];
$jadwalHariIni = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM jadwal WHERE tanggal='$today'"))['total'];
?>

<div class="container mt-4">

    <div class="dashboard-header">
        <img src="assets/img/logo-smg.png" alt="Logo DPPPA Kota Semarang">
        <h2>DASHBOARD ARSIP</h2>
        <h5>Dinas Pemberdayaan Perempuan dan Perlindungan Anak<br>Kota Semarang</h5>
        <p class="mt-2">Selamat datang, <strong><?= htmlspecialchars($namaUser) ?></strong> (<?= ucfirst($roleUser) ?>)</p>
    </div>

    <!-- Statistik Utama -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <a href="surat_masuk/index.php" class="text-decoration-none">
                <div class="card card-custom bg-danger text-white text-center shadow-sm p-3">
                    <i class="fas fa-envelope-open card-icon"></i>
                    <h6>Surat Masuk</h6>
                    <h3><?= $suratMasuk ?></h3>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="surat_keluar/index.php" class="text-decoration-none">
                <div class="card card-custom bg-success text-white text-center shadow-sm p-3">
                    <i class="fas fa-paper-plane card-icon"></i>
                    <h6>Surat Keluar</h6>
                    <h3><?= $suratKeluar ?></h3>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <div class="card card-custom bg-warning text-dark text-center shadow-sm p-3">
                <i class="fas fa-tasks card-icon"></i>
                <h6>Disposisi</h6>
                <h3><?= $disposisi ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <a href="manajemen_user/index.php" class="text-decoration-none">
                <div class="card card-custom bg-secondary text-white text-center shadow-sm p-3">
                    <i class="fas fa-users card-icon"></i>
                    <h6>User</h6>
                    <h3><?= $userCount ?></h3>
                </div>
            </a>
        </div>
    </div>

    <!-- Statistik Hari Ini -->
    <div class="row g-4">
        <div class="col-md-6">
            <a href="surat_masuk/index.php?tanggal=<?= $today ?>" class="text-decoration-none">
                <div class="card card-custom bg-primary text-white text-center shadow-sm p-3">
                    <i class="fas fa-calendar-day card-icon"></i>
                    <h6>Surat Masuk Hari Ini</h6>
                    <h3><?= $suratHariIni ?></h3>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="jadwal/index.php?tanggal=<?= $today ?>" class="text-decoration-none">
                <div class="card card-custom bg-info text-white text-center shadow-sm p-3">
                    <i class="fas fa-clock card-icon"></i>
                    <h6>Jadwal Hari Ini</h6>
                    <h3><?= $jadwalHariIni ?></h3>
                </div>
            </a>
        </div>
    </div>

</div>

<?php include 'templates/footer.php'; ?>
