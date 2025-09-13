<?php
session_start();
// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['status']) && $_SESSION['status'] == "login") {
    header("location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Aplikasi Persuratan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { 
      background-color: #f8f9fa; 
      font-family: 'Poppins', sans-serif;
    }
    .login-container { 
      margin-top: 8%; 
    }
    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
    }
    .card-header {
      background-color: #C8102E;
      color: #fff;
      font-weight: 600;
      border-radius: 12px 12px 0 0;
    }
    .btn-primary {
      background-color: #C8102E;
      border: none;
      font-weight: 600;
    }
    .btn-primary:hover {
      background-color: #a50d24;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4 login-container">
        <div class="card">
          <div class="card-header text-center">
            <h4><i class="fas fa-envelope-open-text me-2"></i> LOGIN APLIKASI ARSIP</h4>
          </div>
          <div class="card-body">
            <?php if (isset($_GET['pesan'])): ?>
              <?php if ($_GET['pesan'] == "gagal"): ?>
                <div class="alert alert-danger">Login gagal! Username atau password salah.</div>
              <?php elseif ($_GET['pesan'] == "logout"): ?>
                <div class="alert alert-success">Anda telah berhasil logout.</div>
              <?php elseif ($_GET['pesan'] == "belum_login"): ?>
                <div class="alert alert-warning">Anda harus login untuk mengakses halaman.</div>
              <?php endif; ?>
            <?php endif; ?>

            <form action="proses_login.php" method="post">
              <div class="mb-3">
                <label class="form-label fw-bold">Username</label>
                <input type="text" class="form-control" name="username" required>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold">Password</label>
                <input type="password" class="form-control" name="password" required>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary shadow-sm">
                  <i class="fas fa-sign-in-alt me-1"></i> Login
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
