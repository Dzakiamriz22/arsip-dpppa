<nav class="navbar navbar-expand-lg shadow-sm sticky-top" style="background-color:#C8102E;">
  <div class="container-fluid">

    <!-- Logo + Nama Instansi -->
    <a class="navbar-brand d-flex align-items-center text-white" href="/arsip-dpppa/index.php">
      <img src="/arsip-dpppa/assets/img/logo-smg.png" alt="Logo DPPPA" height="50" class="me-2">
      <span class="fw-bold text-uppercase">DPPPA Kota Semarang</span>
    </a>

    <!-- Toggler -->
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">

        <li class="nav-item mx-1">
          <a class="nav-link text-white fw-medium" href="/arsip-dpppa/index.php">
            <i class="fas fa-home me-1"></i> Dashboard
          </a>
        </li>

        <li class="nav-item mx-1">
          <a class="nav-link text-white fw-medium" href="/arsip-dpppa/surat_masuk/index.php">
            <i class="fas fa-envelope-open me-1"></i> Surat Masuk
          </a>
        </li>

        <li class="nav-item mx-1">
          <a class="nav-link text-white fw-medium" href="/arsip-dpppa/surat_keluar/index.php">
            <i class="fas fa-paper-plane me-1"></i> Surat Keluar
          </a>
        </li>

        <li class="nav-item mx-1">
          <a class="nav-link text-white fw-medium" href="/arsip-dpppa/jadwal/index.php">
            <i class="fas fa-calendar-alt me-1"></i> Jadwal
          </a>
        </li>

        <li class="nav-item mx-1">
          <a class="nav-link text-white fw-medium" href="/arsip-dpppa/arsip_digital/index.php">
            <i class="fas fa-archive me-1"></i> Arsip Digital
          </a>
        </li>

        <?php if ($_SESSION['role'] == 'admin'): ?>
        <li class="nav-item mx-1">
          <a class="nav-link text-white fw-medium" href="/arsip-dpppa/manajemen_user/index.php">
            <i class="fas fa-users-cog me-1"></i> Manajemen User
          </a>
        </li>
        <?php endif; ?>

        <!-- Divider -->
        <li class="nav-item mx-2">
          <span class="text-white-50">|</span>
        </li>

        <!-- Logout -->
        <li class="nav-item mx-1">
          <a class="nav-link fw-bold" style="color:#FFD700;" href="/arsip-dpppa/logout.php">
            <i class="fas fa-sign-out-alt me-1"></i> Logout
          </a>
        </li>

      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
