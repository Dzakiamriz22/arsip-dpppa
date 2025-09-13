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

$query = "SELECT * FROM users 
          WHERE username LIKE '%$search%' 
             OR nama_lengkap LIKE '%$search%' 
          ORDER BY id_user ASC";
$result = mysqli_query($koneksi, $query);
?>

<div class="container mt-4">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary">👥 Manajemen User</h4>
    <a href="add.php" class="btn btn-success shadow-sm">
      <i class="fas fa-user-plus me-1"></i> Tambah User
    </a>
  </div>

  <!-- Form Pencarian -->
  <form class="mb-3" method="get">
    <div class="input-group shadow-sm">
      <input type="text" name="search" class="form-control" 
             placeholder="Cari username atau nama lengkap..." 
             value="<?= htmlspecialchars($search) ?>">
      <button class="btn btn-danger fw-bold" type="submit">
        <i class="fas fa-search me-1"></i> Cari
      </button>
    </div>
  </form>

  <!-- Tabel User -->
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle shadow-sm">
      <thead class="text-white" style="background-color:#C8102E;">
        <tr class="text-center">
          <th style="width:50px;">No</th>
          <th>Username</th>
          <th>Nama Lengkap</th>
          <th>Role</th>
          <th style="width:150px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
            <td class="text-center">
              <span class="badge bg-<?= $row['role']=='admin' ? 'danger' : 'primary' ?>">
                <?= ucfirst($row['role']) ?>
              </span>
            </td>
            <td class="text-center">
              <a href="edit.php?id=<?= $row['id_user'] ?>" 
                 class="btn btn-sm btn-warning">
                 <i class="fas fa-edit"></i>
              </a>
              <a href="delete.php?id=<?= $row['id_user'] ?>" 
                 class="btn btn-sm btn-danger" 
                 onclick="return confirm('Yakin ingin menghapus user ini?')">
                 <i class="fas fa-trash"></i>
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
        <?php if(mysqli_num_rows($result)==0): ?>
          <tr>
            <td colspan="5" class="text-center text-muted">Belum ada user.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include '../templates/footer.php'; ?>
