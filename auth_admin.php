<?php
require_once 'auth.php';
require_once 'koneksi.php';

// harus login dulu
wajibLogin();

// ambil data user yang sedang login, pastikan role admin
$id_login = intval($_SESSION['user_id']);
$q_login = mysqli_query($koneksi, "SELECT * FROM users WHERE id = $id_login");
$user_login = mysqli_fetch_assoc($q_login);

if (!$user_login) {
    header("location:logout.php");
    exit;
}
if ($user_login['role'] != 'admin') {
    header("location:index.php");
    exit;
}