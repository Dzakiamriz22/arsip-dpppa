<?php
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

$units = ["Sekretariat", "PPA", "Permasdatin", "PPPUG", "UPTD PPA", "PHA"];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold text-primary">📂 Arsip Digital</h4>
</div>

<div class="row">
  <?php foreach($units as $unit): ?>
    <div class="col-md-4 mb-3">
      <div class="card shadow-sm border-0">
        <div class="card-body text-center">
          <h5 class="fw-bold"><?= htmlspecialchars($unit) ?></h5>
          <a href="arsip.php?unit=<?= urlencode($unit) ?>" class="btn btn-primary shadow-sm mt-2">
            <i class="fas fa-folder-open me-1"></i> Lihat Arsip
          </a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php include '../templates/footer.php'; ?>
