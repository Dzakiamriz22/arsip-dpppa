<?php
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';
?>

<?php
$units = ["Sekretariat", "PPA", "Permasdatin", "PPPUG", "UPTD PPA", "PHA"];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Arsip Digital</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
  <h1 class="mb-4">Arsip Digital</h1>
  <div class="row">
    <?php foreach($units as $unit): ?>
      <div class="col-md-4 mb-3">
        <div class="card shadow">
          <div class="card-body text-center">
            <h5><?= $unit ?></h5>
            <a href="arsip.php?unit=<?= urlencode($unit) ?>" class="btn btn-primary mt-2">Lihat Arsip</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</body>
</html>

<?php include '../templates/footer.php'; ?>
