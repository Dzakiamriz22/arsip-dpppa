<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="/arsip-dpppa/index.php">ARSIP DPPPA</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/arsip-dpppa/index.php">
            <i class="fas fa-home"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/arsip-dpppa/surat_masuk/index.php">
            <i class="fas fa-envelope-open"></i> Surat Masuk
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/arsip-dpppa/surat_keluar/index.php">
            <i class="fas fa-paper-plane"></i> Surat Keluar
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/arsip-dpppa/jadwal/index.php">
            <i class="fas fa-calendar-alt"></i> Jadwal
          </a>
        </li>
        <?php if ($_SESSION['role'] == 'admin'): ?>
        <li class="nav-item">
          <a class="nav-link" href="/arsip-dpppa/manajemen_user/index.php">
            <i class="fas fa-users-cog"></i> Manajemen User
          </a>
        </li>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="/arsip-dpppa/logout.php">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
