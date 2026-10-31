<?php
require_once 'auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil role pengguna
$role = strtolower(trim($_SESSION['role'] ?? ''));

// Periksa role pengguna
if ($role === '') {
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit;
}

// Arahkan pengguna ke halaman sesuai role
if (function_exists('halaman_awal')) {
    header("Location: " . halaman_awal($role));
    exit;
}

// Jika fungsi halaman_awal tidak tersedia
switch ($role) {
    case 'Form2':
        header("Location: form2.php");
        break;

    case 'Form_Edit_User':
        header("Location: form_edit_user.php");
        break;

    case 'Formall':
        header("Location: formall.php");
        break;

    default:
        session_unset();
        session_destroy();
        header("Location: login.php");
        break;
}

exit;