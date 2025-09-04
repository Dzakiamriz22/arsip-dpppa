<?php
include 'templates/header.php';
include 'templates/navbar.php';
include 'config/koneksi.php';

// Ambil info user
$namaUser = $_SESSION['nama_lengkap'];
$roleUser = $_SESSION['role'];

// Ambil jumlah data
$suratMasuk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM surat_masuk"))['total'];
$suratKeluar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM surat_keluar"))['total'];
$disposisi   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM disposisi_surat"))['total'];
$jadwal      = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM jadwal"))['total'];
$userCount   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM users"))['total'];

// Jumlah surat & jadwal hari ini
$today = date('Y-m-d');
$suratHariIni = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM surat_masuk WHERE tanggal_masuk='$today'"))['total'];
$jadwalHariIni = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM jadwal WHERE tanggal='$today'"))['total'];

// 5 surat masuk terbaru
$recentSurat = mysqli_query($koneksi, "SELECT * FROM surat_masuk ORDER BY tanggal_masuk DESC LIMIT 5");
// 5 jadwal terbaru
$recentJadwal = mysqli_query($koneksi, "SELECT * FROM jadwal ORDER BY tanggal DESC, waktu ASC LIMIT 5");
?>

<div class="container mt-4">
    <div class="mb-4">
        <h3>Selamat datang, <?= htmlspecialchars($namaUser) ?>!</h3>
        <p>Anda login sebagai <strong><?= htmlspecialchars(ucfirst($roleUser)) ?></strong></p>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm border-start border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted">Surat Masuk</h6>
                            <h3><?= $suratMasuk ?></h3>
                        </div>
                        <div class="ms-3 text-primary">
                            <i class="fas fa-envelope-open fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-start border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted">Surat Keluar</h6>
                            <h3><?= $suratKeluar ?></h3>
                        </div>
                        <div class="ms-3 text-success">
                            <i class="fas fa-paper-plane fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-start border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted">Disposisi</h6>
                            <h3><?= $disposisi ?></h3>
                        </div>
                        <div class="ms-3 text-warning">
                            <i class="fas fa-tasks fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-start border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted">Jadwal</h6>
                            <h3><?= $jadwal ?></h3>
                        </div>
                        <div class="ms-3 text-info">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm border-start border-secondary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted">User Terdaftar</h6>
                            <h3><?= $userCount ?></h3>
                        </div>
                        <div class="ms-3 text-secondary">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-start border-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted">Surat Hari Ini</h6>
                            <h3><?= $suratHariIni ?></h3>
                        </div>
                        <div class="ms-3 text-danger">
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-start border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted">Jadwal Hari Ini</h6>
                            <h3><?= $jadwalHariIni ?></h3>
                        </div>
                        <div class="ms-3 text-primary">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Tabel ringkasan terbaru -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5>Surat Masuk Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Surat</th>
                                <th>Pengirim</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; while($row = mysqli_fetch_assoc($recentSurat)): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['nomor_surat'] ?></td>
                                    <td><?= htmlspecialchars($row['pengirim']) ?></td>
                                    <td><?= date('d-m-Y', strtotime($row['tanggal_masuk'])) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5>Jadwal Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kegiatan</th>
                                <th>Waktu</th>
                                <th>Tempat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; while($row = mysqli_fetch_assoc($recentJadwal)): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['kegiatan']) ?></td>
                                    <td><?= $row['waktu'] ?></td>
                                    <td><?= htmlspecialchars($row['tempat']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'templates/footer.php'; ?>
