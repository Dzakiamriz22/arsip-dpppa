<?php
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){
    header('location:../index.php');
    exit;
}

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id_user=$id"));

if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $role = $_POST['role'];

    if(!empty($_POST['password'])){
        $password = md5($_POST['password']);
        mysqli_query($koneksi, "UPDATE users SET username='$username', password='$password', nama_lengkap='$nama_lengkap', role='$role' WHERE id_user=$id");
    } else {
        mysqli_query($koneksi, "UPDATE users SET username='$username', nama_lengkap='$nama_lengkap', role='$role' WHERE id_user=$id");
    }
    header('location:index.php');
}
?>

<div class="container mt-4">
    <h4>Edit User</h4>
    <form method="post">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($data['username']) ?>">
        </div>
        <div class="mb-3">
            <label>Password <small>(kosongkan jika tidak ingin diubah)</small></label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($data['nama_lengkap']) ?>">
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="admin" <?= $data['role']=='admin'?'selected':'' ?>>Admin</option>
                <option value="viewer" <?= $data['role']=='viewer'?'selected':'' ?>>Viewer</option>
            </select>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include '../templates/footer.php'; ?>
