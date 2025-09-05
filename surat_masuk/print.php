<?php
session_start();
include '../config/koneksi.php';

// cek session
if(empty($_SESSION['role'])){
    $_SESSION['err'] = '<strong>ERROR!</strong> Anda harus login terlebih dahulu.';
    header("Location: ./");
    die();
} else {

echo '

<style type="text/css" media="print">
  #screen_view_container{
        display: none;
  }
</style>

<style type="text/css">
    body {
        font-size: 12px; 
        color: #212121; 
        display: flex; 
        justify-content: center; 
    }
    .container {
        width: 80%;      /* atur lebar konten */
        margin: 0 auto;  /* biar center */
    }
    table {
        background: #fff;
        padding: 5px;
        width: 100%;
    }
    tr, td {
        border: table-cell;
        border: 1px solid #444;
    }
    tr,td {
        vertical-align: top!important;
    }
    #right { border-right: none !important; }
    #left { border-left: none !important; }
    .isi { height: 300px!important; }
    .disp { text-align: center; padding: 1.5rem 0; margin-bottom: .5rem; }
    .logodisp { float: left; position: relative; width: 110px; height: 110px; margin: 0 0 0 1rem; }
    #lead { width: auto; position: relative; margin: 25px 0 0 75%; }
    .lead { font-weight: bold; text-decoration: underline; margin-bottom: -10px; }
    .tgh { text-align: center; }
    #nama { font-size: 2.1rem; margin-bottom: -1rem; }
    #alamat { font-size: 16px; }
    .up { text-transform: uppercase; margin: 0; line-height: 2.2rem; font-size: 1.5rem; }
    .status { margin: 0; font-size: 1.3rem; margin-bottom: .5rem; }
    #lbr { font-size: 20px; font-weight: bold; }
    .separator { border-bottom: 2px solid #616161; margin: -1.3rem 0 1.5rem; }

    @media print{
        body { 
            font-size: 12px; 
            color: #212121; 
            display: flex;
            justify-content: center;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        table { width: 100%; font-size: 12px; color: #212121; }
        tr, td { border: table-cell; border: 1px solid #444; padding: 8px!important; }
        .isi { height: 200px!important; }
        .tgh { text-align: center; }
        .disp { text-align: center; margin: -.5rem 0; }
        .logodisp { float: left; width: 80px; height: 80px; margin: .5rem 0 0 .5rem; }
        #lead { margin: 15px 0 0 75%; }
        #nama { font-size: 20px!important; font-weight: bold; text-transform: uppercase; margin: -10px 0 -20px 0; }
        .up { font-size: 17px!important; }
        .status { font-size: 17px!important; margin-bottom: -.1rem; }
        #alamat { margin-top: -15px; font-size: 13px; }
        #lbr { font-size: 17px; font-weight: bold; }
        .separator { border-bottom: 2px solid #616161; margin: -1rem 0 1rem; }
    }
</style>

<body onload="window.print()">

<!-- Container START -->
<div class="container">
    <div id="colres">
        <div class="disp">';

// Hardcode identitas instansi
echo '<img class="logodisp" src="./asset/img/logo.png"/>';
echo '<h6 class="up">DPPPA KOTA SEMARANG</h6>';
echo '<h5 class="up" id="nama">LEMBAR SURAT MASUK</h5><br/>';
echo '<h6 class="status">Bagian Umum (Status)</h6>';
echo '<span id="alamat">Jl. Contoh Alamat No. 123, Semarang</span>';

echo '
        </div>
        <div class="separator"></div>';

// ambil id surat
$id_surat = mysqli_real_escape_string($koneksi, $_REQUEST['id_surat']);

// query gabung surat masuk + disposisi
$query = mysqli_query($koneksi, "SELECT sm.*, ds.tujuan, ds.batas_waktu, ds.isi, ds.catatan, ds.sifat 
                                 FROM surat_masuk sm 
                                 LEFT JOIN disposisi_surat ds 
                                 ON sm.id_surat_masuk = ds.id_surat_masuk 
                                 WHERE sm.id_surat_masuk='$id_surat'");

if(mysqli_num_rows($query) > 0){
    $row = mysqli_fetch_array($query);

    // Format tanggal
    $y = substr($row['tanggal_masuk'],0,4);
    $m = substr($row['tanggal_masuk'],5,2);
    $d = substr($row['tanggal_masuk'],8,2);
    $bulan = [
        "01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April",
        "05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus",
        "09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Desember"
    ];
    $nm = $bulan[$m];

    echo '
        <table class="bordered" id="tbl">
            <tbody>
                <tr>
                    <td class="tgh" id="lbr" colspan="5">LEMBAR DISPOSISI</td>
                </tr>
                <tr>
                    <td id="right" width="18%"><strong>Indeks Berkas</strong></td>
                    <td id="left" width="57%">: tolong tambahkan kolom indeks berkas</td>
                    <td id="left" width="25"><strong>Kode</strong> : tolong tambahkan kolom kode</td>
                </tr>
                <tr>
                    <td id="right"><strong>Tanggal Surat</strong></td>
                    <td id="left" colspan="2">: '.$d.' '.$nm.' '.$y.'</td>
                </tr>
                <tr>
                    <td id="right"><strong>Nomor Surat</strong></td>
                    <td id="left" colspan="2">: '.$row['nomor_surat'].'</td>
                </tr>
                <tr>
                    <td id="right"><strong>Asal Surat</strong></td>
                    <td id="left" colspan="2">: '.$row['pengirim'].'</td>
                </tr>
                <tr>
                    <td id="right"><strong>Isi Ringkas</strong></td>
                    <td id="left" colspan="2">: '.$row['perihal'].'</td>
                </tr>
                <tr>
                    <td id="right"><strong>Diterima Tanggal</strong></td>
                    <td id="left">: '.$d.' '.$nm.' '.$y.'</td>
                    <td id="left"><strong>No. Agenda</strong> : Tolong tambahkan kolom no agenda</td>
                </tr>
                <tr>
                    <td id="right"><strong>Lampiran</strong></td>
                    <td id="left" colspan="2">: '.($row['file_lampiran'] ? $row['file_lampiran'] : "-").'</td>
                </tr>
                <tr class="isi">
                    <td colspan="2" style="padding:10px; vertical-align:top;">
                        <strong>Isi Disposisi :</strong><br/>
                            <div style="min-height:80px;">
                                '.($row['isi'] ? $row['isi'] : "-").'
                            </div>
                        <br/>
                        <strong>Batas Waktu :</strong> 
                            '.($row['batas_waktu'] ? $row['batas_waktu'] : "-").'
                        <br/>
                        <strong>Sifat :</strong> 
                            '.($row['sifat'] ? $row['sifat'] : "-").'
                        <br/>
                        <strong>Catatan :</strong><br/>
                            <div style="min-height:100px;">
                                '.($row['catatan'] ? $row['catatan'] : "-").'
                            </div>
                    </td>

                    <td style="min-height:100px; padding:10px; vertical-align:top;">
                        <strong>Diteruskan Kepada :</strong><br/>
                            <div style="min-height:60px;">
                                '.($row['tujuan'] ? $row['tujuan'] : "-").'
                            </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div id="lead">
            <p>Kepala Dinas</p>
            <div style="height: 50px;"></div>
            <p class="lead">Ganti denga Nama Kepala Dinas</p>
            <p>NIP. Ganti dengan NIP Kepala Dinas</p>
        </div>
    ';
}
echo '
    </div>
    <div class="jarak2"></div>
</div>
<!-- Container END -->

</body>';
}
?>
