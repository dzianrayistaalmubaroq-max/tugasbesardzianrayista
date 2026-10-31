<?php
require_once 'koneksi.php';

$guru_id = (int) ($_POST['guru_id'] ?? 0);
$mapel_id = (int) ($_POST['mapel_id'] ?? 0);
$kelas = trim($_POST['kelas'] ?? '');

$stmt = mysqli_prepare($koneksi,
    "INSERT INTO mengajar (guru_id, mapel_id, kelas)
     VALUES (?, ?, ?)"
);

mysqli_stmt_bind_param($stmt, "iis", $guru_id, $mapel_id, $kelas);

if (mysqli_stmt_execute($stmt)) {
    header("Location: mengajar.php");
    exit;
} else {
    echo "Gagal menambahkan data mengajar";
}
?>
