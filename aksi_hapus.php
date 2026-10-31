<?php
require_once 'koneksi.php';

$id = $_GET['id'];
$role = $_GET['role'];

if ($role == 'siswa') {
    echo 'ini untuk hapus siswa<br>';
    
    // HAPUS DULU dari tabel siswa, BARU tabel users
    $q1 = "DELETE FROM siswa WHERE user_id = '$id'";
    $q2 = "DELETE FROM users WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $q1) && mysqli_query($koneksi, $q2)) {
        echo "<script>alert('Siswa Berhasil Dihapus');window.location.href='daftar_user.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
        echo "<script>alert('Siswa Gagal Dihapus');window.location.href='daftar_user.php';</script>";
    }
    exit;

} elseif ($role == 'guru') {
    echo 'ini untuk hapus guru<br>';
    
    // HAPUS DULU dari tabel guru, BARU tabel users
    $q1 = "DELETE FROM guru WHERE user_id = '$id'";
    $q2 = "DELETE FROM users WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $q1) && mysqli_query($koneksi, $q2)) {
        echo "<script>alert('Guru Berhasil Dihapus');window.location.href='daftar_user.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
        echo "<script>alert('Guru Gagal Dihapus');window.location.href='daftar_user.php';</script>";
    }
    exit;

} else {
    echo 'ini untuk hapus admin<br>';
    
    $sql = "DELETE FROM users WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Admin Berhasil Dihapus');window.location.href='daftar_user.php';</script>";
    } else {
        echo "<script>alert('Admin Gagal Dihapus');window.location.href='daftar_user.php';</script>";
    }
    exit;
}
