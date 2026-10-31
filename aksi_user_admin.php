<?php
include 'auth_admin.php';
mysqli_report(MYSQLI_REPORT_OFF);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("location:daftar_user_admin.php");
    exit;
}

$aksi = $_POST['aksi'];
$id = intval($_POST['id']);

// ===== HAPUS =====
if ($aksi == 'hapus') {
    // admin tidak boleh menghapus akunnya sendiri
    if ($id == $_SESSION['user_id']) {
        header("location:daftar_user_admin.php?pesan=diri");
        exit;
    }
    $hasil = mysqli_query($koneksi, "DELETE FROM users WHERE id = $id");
    if ($hasil) {
        header("location:daftar_user_admin.php?pesan=hapus");
    } else {
        header("location:daftar_user_admin.php?pesan=gagal");
    }
    exit;
}

// ===== SIMPAN (tambah / edit) =====
$username = mysqli_real_escape_string($koneksi, trim($_POST['username']));
$role = $_POST['role'];
$password = $_POST['password'];

if ($username == '' || ($role != 'admin' && $role != 'guru' && $role != 'siswa')) {
    header("location:daftar_user_admin.php?pesan=kosong");
    exit;
}

// admin tidak boleh mengubah role akunnya sendiri
if ($id == $_SESSION['user_id'] && $role != 'admin') {
    header("location:daftar_user_admin.php?pesan=role_diri");
    exit;
}

// password wajib saat tambah, saat edit boleh kosong
if ($id == 0 && strlen($password) < 6) {
    header("location:daftar_user_admin.php?pesan=password");
    exit;
}
if ($id != 0 && $password != '' && strlen($password) < 6) {
    header("location:daftar_user_admin.php?pesan=password");
    exit;
}

// cek username sudah dipakai atau belum
$cek = mysqli_query($koneksi, "SELECT id FROM users WHERE username = '$username' AND id != $id");
if (mysqli_num_rows($cek) > 0) {
    header("location:daftar_user_admin.php?pesan=kembar");
    exit;
}

if ($id == 0) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $hasil = mysqli_query($koneksi, "INSERT INTO users (username, password, role)
        VALUES ('$username', '$hash', '$role')");
    $pesan = "tambah";
} else {
    if ($password != '') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $hasil = mysqli_query($koneksi, "UPDATE users SET username = '$username',
            role = '$role', password = '$hash' WHERE id = $id");
    } else {
        $hasil = mysqli_query($koneksi, "UPDATE users SET username = '$username',
            role = '$role' WHERE id = $id");
    }
    $pesan = "edit";
}

if (!$hasil) {
    $pesan = "gagal";
}
header("location:daftar_user_admin.php?pesan=$pesan");