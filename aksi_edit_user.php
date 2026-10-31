<?php
// Diproses dari form_edit_user.php  (aksi = editadmin | editguru | editsiswa)
require_once 'koneksi.php';

$aksi = $_GET['aksi'] ?? '';
$peran = ['editadmin' => 'admin', 'editguru' => 'guru', 'editsiswa' => 'siswa'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($peran[$aksi])) {
    header("Location: daftar_user.php");
    exit;
}

function selesai($berhasil) {
    $pesan = $berhasil ? 'Data Berhasil Diubah' : 'Data Tidak Berhasil Diubah';
    echo "<script>alert('$pesan'); window.location.href='daftar_user.php';</script>";
    exit;
}

$role     = $peran[$aksi];   // role ditentukan dari aksi, bukan dari input form
$user_id  = (int)($_POST['user_id'] ?? $_POST['id'] ?? 0);   // form admin mengirim 'id' = users.id
$username = trim($_POST['username'] ?? '');
$pass     = $_POST['password'] ?? '';

if ($user_id <= 0 || $username === '') {
    selesai(false);
}

// Pastikan user memang punya role tersebut
$stmt = mysqli_prepare($koneksi, "SELECT id FROM users WHERE id = ? AND role = ?");
mysqli_stmt_bind_param($stmt, "is", $user_id, $role);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
$ada = mysqli_stmt_num_rows($stmt) > 0;
mysqli_stmt_close($stmt);
if (!$ada) {
    selesai(false);
}

mysqli_begin_transaction($koneksi);

// 1. Update tabel users (password hanya diganti kalau diisi)
if ($pass !== '') {
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($koneksi, "UPDATE users SET username = ?, password = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $username, $hash, $user_id);
} else {
    $stmt = mysqli_prepare($koneksi, "UPDATE users SET username = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $username, $user_id);
}
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// 2. Update tabel profil sesuai role
if ($ok && $role === 'siswa') {
    $nis   = trim($_POST['nis'] ?? '');
    $nama  = trim($_POST['nama_lengkap'] ?? '');
    $kelas = trim($_POST['kelas'] ?? '');
    $jk    = $_POST['jenis_kelamin'] ?? '';

    $stmt = mysqli_prepare($koneksi, "UPDATE siswa SET nis = ?, nama = ?, kelas = ?, jenis_kelamin = ? WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "ssssi", $nis, $nama, $kelas, $jk, $user_id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
} elseif ($ok && $role === 'guru') {
    $nip  = trim($_POST['nip'] ?? '');
    $nama = trim($_POST['nama_lengkap'] ?? '');
    $jk   = $_POST['jenis_kelamin'] ?? '';

    $stmt = mysqli_prepare($koneksi, "UPDATE guru SET nip = ?, nama = ?, jenis_kelamin = ? WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "sssi", $nip, $nama, $jk, $user_id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if ($ok) {
    mysqli_commit($koneksi);
} else {
    mysqli_rollback($koneksi);
}
selesai($ok);