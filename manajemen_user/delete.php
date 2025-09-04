<?php
include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){
    header('location:../index.php');
    exit;
}

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM users WHERE id_user=$id");
header('location:index.php');
