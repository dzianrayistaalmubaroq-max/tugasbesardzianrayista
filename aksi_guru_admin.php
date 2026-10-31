<?php
include 'auth_admin.php';
mysqli_report(MYSQLI_REPORT_OFF);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("location:daftar_guru_admin.php");
    exit;
}

$aksi = $_POST['aksi'];
$id = intval($_POST['id']);

// ===== HAPUS =====
if ($aksi == 'hapus') {
    $hasil = mysqli_query($koneksi, "DELETE FROM guru WHERE id = $id");
    if ($hasil) {
        header("location:daftar_guru_admin.php?pesan=hapus");
    } else {
        header("location:daftar_guru_admin.php?pesan=gagal");
    }
    exit;
}

// ===== SIMPAN (tambah / edit) =====
$nip = mysqli_real_escape_string($koneksi, trim($_POST['nip']));
$nama = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
$jk = $_POST['jenis_kelamin'];
$user_id = intval($_POST['user_id']);

if ($nip == '' || $nama == '' || ($jk != 'L' && $jk != 'P')) {
    header("location:daftar_guru_admin.php?pesan=kosong");
    exit;
}

// cek NIP sudah dipakai atau belum
$cek = mysqli_query($koneksi, "SELECT id FROM guru WHERE nip = '$nip' AND id != $id");
if (mysqli_num_rows($cek) > 0) {
    header("location:daftar_guru_admin.php?pesan=kembar");
    exit;
}

// cek akun: harus role guru dan belum dipakai guru lain
if ($user_id == 0) {
    $user_sql = "NULL";
} else {
    $cek_akun = mysqli_query($koneksi, "SELECT id FROM users
        WHERE id = $user_id AND role = 'guru'
        AND id NOT IN (SELECT user_id FROM guru WHERE user_id IS NOT NULL AND id != $id)");
    if (mysqli_num_rows($cek_akun) == 0) {
        header("location:daftar_guru_admin.php?pesan=akun");
        exit;
    }
    $user_sql = $user_id;
}

if ($id == 0) {
    $hasil = mysqli_query($koneksi, "INSERT INTO guru (nip, nama, jenis_kelamin, user_id)
        VALUES ('$nip', '$nama', '$jk', $user_sql)");
    $pesan = "tambah";
} else {
    $hasil = mysqli_query($koneksi, "UPDATE guru SET nip = '$nip', nama = '$nama',
        jenis_kelamin = '$jk', user_id = $user_sql WHERE id = $id");
    $pesan = "edit";
}

if (!$hasil) {
    $pesan = "gagal";
}
header("location:daftar_guru_admin.php?pesan=$pesan");