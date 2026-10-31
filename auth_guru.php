<?php
require_once 'auth.php';
require_once 'koneksi.php';

// harus login dulu
wajibLogin();

// ambil data akun yang sedang login, pastikan role guru
$id_login = intval($_SESSION['user_id']);
$q_login = mysqli_query($koneksi, "SELECT * FROM users WHERE id = $id_login");
$user_login = mysqli_fetch_assoc($q_login);

if (!$user_login) {
    header("location:logout.php");
    exit;
}
if ($user_login['role'] != 'guru') {
    header("location:index.php");
    exit;
}

// data guru (kosong kalau akun belum dihubungkan oleh admin)
$q_guru = mysqli_query($koneksi, "SELECT * FROM guru WHERE user_id = $id_login");
$guru_login = mysqli_fetch_assoc($q_guru);

$id_guru = 0;
$nama_login = $user_login['username'];
if ($guru_login) {
    $id_guru = intval($guru_login['id']);
    $nama_login = $guru_login['nama'];
}