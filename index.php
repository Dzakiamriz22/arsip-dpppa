<?php
include 'templates/header.php';
include 'templates/navbar.php';
include 'config/koneksi.php';

$namaUser = $_SESSION['nama_lengkap'];
$roleUser = $_SESSION['role'];

// Ambil jumlah data
$data = [
    'suratMasuk'   => mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM surat_masuk"))['total'],
    'suratKeluar'  => mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM surat_keluar"))['total'],
    'disposisi'    => mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM disposisi_surat"))['total'],
    'userCount'    => mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM users"))['total'],
    'arsipDigital' => mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM arsip_digital"))['total'],
];

$today = date('Y-m-d');
$data['suratHariIni']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM surat_masuk WHERE tanggal_masuk='$today'"))['total'];
$data['jadwalHariIni'] = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM jadwal WHERE tanggal='$today'"))['total'];
?>

<div class="container mt-5">
    <div class="text-center mb-5">
        <img src="assets/img/logo-smg.png" alt="Logo DPPPA Kota Semarang" class="mb-3" style="height: 80px;">
        <h2 class="fw-bold">DASHBOARD ARSIP</h2>
        <h5 class="text-muted">Dinas Pemberdayaan Perempuan dan Perlindungan Anak Kota Semarang</h5>
        <p class="mt-3">Selamat datang, <strong><?= htmlspecialchars($namaUser) ?></strong> (<?= ucfirst($roleUser) ?>)</p>
    </div>

    <!-- Baris 1: 3 Card -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <a href="surat_masuk/index.php" class="text-decoration-none">
                <div class="card text-white bg-danger text-center shadow-sm p-4 h-100">
                    <div class="mb-2"><i class="fas fa-envelope-open fa-2x"></i></div>
                    <h6 class="mb-1">Surat Masuk</h6>
                    <h3 class="fw-bold"><?= $data['suratMasuk'] ?></h3>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="surat_keluar/index.php" class="text-decoration-none">
                <div class="card text-white bg-success text-center shadow-sm p-4 h-100">
                    <div class="mb-2"><i class="fas fa-paper-plane fa-2x"></i></div>
                    <h6 class="mb-1">Surat Keluar</h6>
                    <h3 class="fw-bold"><?= $data['suratKeluar'] ?></h3>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark text-center shadow-sm p-4 h-100">
                <div class="mb-2"><i class="fas fa-tasks fa-2x"></i></div>
                <h6 class="mb-1">Disposisi</h6>
                <h3 class="fw-bold"><?= $data['disposisi'] ?></h3>
            </div>
        </div>
    </div>

    <!-- Baris 2: 2 Card -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <a href="manajemen_user/index.php" class="text-decoration-none">
                <div class="card text-white bg-secondary text-center shadow-sm p-4 h-100">
                    <div class="mb-2"><i class="fas fa-users fa-2x"></i></div>
                    <h6 class="mb-1">User</h6>
                    <h3 class="fw-bold"><?= $data['userCount'] ?></h3>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="arsip_digital/index.php" class="text-decoration-none">
                <div class="card text-white bg-dark text-center shadow-sm p-4 h-100">
                    <div class="mb-2"><i class="fas fa-archive fa-2x"></i></div>
                    <h6 class="mb-1">Arsip Digital</h6>
                    <h3 class="fw-bold"><?= $data['arsipDigital'] ?></h3>
                </div>
            </a>
        </div>
    </div>

    <!-- Baris 3: 2 Card -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <a href="surat_masuk/index.php?tanggal=<?= $today ?>" class="text-decoration-none">
                <div class="card text-white bg-primary text-center shadow-sm p-4 h-100">
                    <div class="mb-2"><i class="fas fa-calendar-day fa-2x"></i></div>
                    <h6 class="mb-1">Surat Masuk Hari Ini</h6>
                    <h3 class="fw-bold"><?= $data['suratHariIni'] ?></h3>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="jadwal/index.php?tanggal=<?= $today ?>" class="text-decoration-none">
                <div class="card text-white bg-info text-center shadow-sm p-4 h-100">
                    <div class="mb-2"><i class="fas fa-clock fa-2x"></i></div>
                    <h6 class="mb-1">Jadwal Hari Ini</h6>
                    <h3 class="fw-bold"><?= $data['jadwalHariIni'] ?></h3>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
