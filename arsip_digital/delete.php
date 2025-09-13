<?php
include "functions.php";

$id = $_GET['id'] ?? 0;
$data = getArsipById($id);

if ($data) {
    unlink($data['file_path']); // hapus file fisik
    $conn->query("DELETE FROM arsip_digital WHERE id=$id");
}

header("Location: arsip.php?unit=" . urlencode($data['unit']));
exit;
