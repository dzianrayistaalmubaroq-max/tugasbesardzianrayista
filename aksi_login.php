<?php
require_once 'auth.php';
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

function balik($pesan) {
    header("Location: login.php?error=" . urlencode($pesan));
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    balik("Username dan password wajib diisi.");
}

$stmt = mysqli_prepare($koneksi, "SELECT id, username, password, role FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$u = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$u || !($password === $u['password'] || password_verify($password, $u['password']))) {
    balik("Username atau password salah.");
}

$role = strtolower($u['role']);
$nama = $u['username'];

if ($role == 'siswa' || $role == 'guru') {
    $q = mysqli_query($koneksi, "SELECT nama FROM $role WHERE user_id = " . (int) $u['id']);
    $p = $q ? mysqli_fetch_assoc($q) : null;
    if ($p && $p['nama'] !== '') $nama = $p['nama'];
}

session_regenerate_id(true);
$_SESSION['user_id']  = (int) $u['id'];
$_SESSION['username'] = $u['username'];
$_SESSION['nama']     = $nama;
$_SESSION['role']     = $role;

switch ($role) {
    case 'admin':
        header("Location: daftar_user.php");
        break;
    case 'siswa':
        header("Location: daftar_siswa.php");
        break;
    default:
        header("Location: index.php");
        break;
}
exit;