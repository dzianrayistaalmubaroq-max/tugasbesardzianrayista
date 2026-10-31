<?php
require_once 'koneksi.php';

$kode_mapel = $_POST['kode_mapel'] ?? '';
$nama_mapel = $_POST['nama_mapel'] ?? '';

$stmt = mysqli_prepare($koneksi,
    "INSERT INTO mapel (kode_mapel, nama_mapel) VALUES (?, ?)"
);

mysqli_stmt_bind_param($stmt, "ss", $kode_mapel, $nama_mapel);

if (mysqli_stmt_execute($stmt)) {
    header("Location: mapel.php");
    exit;
} else {
    echo "Gagal menambahkan mapel";
}
?>
