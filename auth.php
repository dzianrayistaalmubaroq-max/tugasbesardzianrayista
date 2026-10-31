<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Daftar role yang diizinkan
define('ROLE_BOLEH', ['admin', 'guru', 'siswa']);

// Memeriksa apakah pengguna sudah login
function wajibLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}

// Menentukan halaman berdasarkan role pengguna
function halaman_awal($role) {
    switch ($role) {
        case 'user':
            return 'daftar_user.php';

        case 'guru':
            return 'daftar_guru.php';

        case 'siswa':
            return 'daftar_siswa.php';

        default:
            session_destroy();
            header("Location: login.php");
            exit;
    }
}
?>