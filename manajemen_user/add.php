<?php
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){
    header('location:../index.php');
    exit;
}

if(isset($_POST['submit'])){
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $role = $_POST['role'];

    mysqli_query($koneksi, "INSERT INTO users (username, password, nama_lengkap, role) VALUES ('$username','$password','$nama_lengkap','$role')");
    header('location:index.php');
}
?>

<div class="container mt-4">
    <h4>Tambah User</h4>
    <form method="post">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control">
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="admin">Admin</option>
                <option value="viewer" selected>Viewer</option>
            </select>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include '../templates/footer.php'; ?>
