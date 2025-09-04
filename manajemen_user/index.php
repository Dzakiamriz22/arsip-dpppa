<?php
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

// Cek role admin
if($_SESSION['role'] != 'admin'){
    header('location:../index.php');
    exit;
}

$search = '';
if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
}

$query = "SELECT * FROM users WHERE username LIKE '%$search%' OR nama_lengkap LIKE '%$search%' ORDER BY id_user ASC";
$result = mysqli_query($koneksi, $query);
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h4>Manajemen User</h4>
        <a href="add.php" class="btn btn-success">Tambah User</a>
    </div>

    <form class="mb-3" method="get">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari username atau nama..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                <td><?= ucfirst($row['role']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id_user'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=<?= $row['id_user'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
            <?php if(mysqli_num_rows($result)==0): ?>
                <tr><td colspan="5" class="text-center">Belum ada user.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>
