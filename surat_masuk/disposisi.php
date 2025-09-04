<?php
include '../templates/header.php';
include '../templates/navbar.php';
include '../config/koneksi.php';

if ($_SESSION['role'] != 'admin') {
    echo "<div class='alert alert-danger'>Hanya admin yang bisa menambahkan disposisi.</div>";
    include '../templates/footer.php';
    exit;
}

$id_surat = $_GET['id'];

// Cek apakah surat ada
$cekSurat = mysqli_query($koneksi, "SELECT * FROM surat_masuk WHERE id_surat_masuk='$id_surat'");
if(mysqli_num_rows($cekSurat)==0){
    echo "<div class='alert alert-danger'>Surat tidak ditemukan.</div>";
    include '../templates/footer.php';
    exit;
}

// Cek apakah disposisi sudah ada
$cekDisposisi = mysqli_query($koneksi, "SELECT * FROM disposisi_surat WHERE id_surat_masuk='$id_surat'");
$disposisi = mysqli_fetch_assoc($cekDisposisi);

if(isset($_POST['submit'])){
    $tujuan = mysqli_real_escape_string($koneksi, $_POST['tujuan']);
    $batas_waktu = $_POST['batas_waktu'];
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $catatan = mysqli_real_escape_string($koneksi, $_POST['catatan']);
    $sifat = $_POST['sifat'];

    if($disposisi){
        // update
        mysqli_query($koneksi, "UPDATE disposisi_surat SET tujuan='$tujuan', batas_waktu='$batas_waktu', isi='$isi', catatan='$catatan', sifat='$sifat' WHERE id_surat_masuk='$id_surat'");
        echo "<div class='alert alert-success'>Disposisi berhasil diperbarui.</div>";
    } else {
        // insert
        mysqli_query($koneksi, "INSERT INTO disposisi_surat (id_surat_masuk, tujuan, batas_waktu, isi, catatan, sifat) VALUES ('$id_surat','$tujuan','$batas_waktu','$isi','$catatan','$sifat')");
        echo "<div class='alert alert-success'>Disposisi berhasil ditambahkan.</div>";
    }

    // Refresh data
    $cekDisposisi = mysqli_query($koneksi, "SELECT * FROM disposisi_surat WHERE id_surat_masuk='$id_surat'");
    $disposisi = mysqli_fetch_assoc($cekDisposisi);
}
?>

<div class="card">
  <div class="card-header"><h4>Disposisi Surat</h4></div>
  <div class="card-body">
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Tujuan Disposisi</label>
            <input type="text" class="form-control" name="tujuan" value="<?= $disposisi['tujuan'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Batas Waktu</label>
            <input type="date" class="form-control" name="batas_waktu" value="<?= $disposisi['batas_waktu'] ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Isi Disposisi</label>
            <textarea class="form-control" name="isi" rows="4" required><?= $disposisi['isi'] ?? ''; ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea class="form-control" name="catatan" rows="2"><?= $disposisi['catatan'] ?? ''; ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Sifat Disposisi</label>
            <select class="form-select" name="sifat">
                <?php 
                $sifatList = ['Biasa','Penting','Segera','Rahasia'];
                foreach($sifatList as $s){
                    $selected = ($disposisi['sifat'] ?? '') == $s ? 'selected' : '';
                    echo "<option value='$s' $selected>$s</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Simpan Disposisi</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
</div>

<?php include '../templates/footer.php'; ?>
