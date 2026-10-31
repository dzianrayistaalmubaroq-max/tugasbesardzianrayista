<?php
include 'auth_admin.php';
mysqli_report(MYSQLI_REPORT_OFF);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("location:daftar_siswa_admin.php");
    exit;
}

$aksi = $_POST['aksi'];
$id = intval($_POST['id']);

// ===== HAPUS =====
if ($aksi == 'hapus') {
    $hasil = mysqli_query($koneksi, "DELETE FROM siswa WHERE id = $id");
    if ($hasil) {
        header("location:daftar_siswa_admin.php?pesan=hapus");
    } else {
        header("location:daftar_siswa_admin.php?pesan=gagal");
    }
    exit;
}

// ===== SIMPAN (tambah / edit) =====
$nis_asli = trim($_POST['nis']);
$kelas_asli = trim($_POST['kelas']);
$nis = mysqli_real_escape_string($koneksi, $nis_asli);
$kelas = mysqli_real_escape_string($koneksi, $kelas_asli);
$nama = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
$jk = $_POST['jenis_kelamin'];
$user_id = intval($_POST['user_id']);

if ($nis == '' || $nama == '' || $kelas == '' || ($jk != 'L' && $jk != 'P')) {
    header("location:daftar_siswa_admin.php?pesan=kosong");
    exit;
}

// NIS dan kelas di database maksimal 10 karakter
if (strlen($nis_asli) > 10 || strlen($kelas_asli) > 10) {
    header("location:daftar_siswa_admin.php?pesan=panjang");
    exit;
}

// cek NIS sudah dipakai atau belum
$cek = mysqli_query($koneksi, "SELECT id FROM siswa WHERE nis = '$nis' AND id != $id");
if (mysqli_num_rows($cek) > 0) {
    header("location:daftar_siswa_admin.php?pesan=kembar");
    exit;
}

// cek akun: harus role siswa dan belum dipakai siswa lain
if ($user_id == 0) {
    $user_sql = "NULL";
} else {
    $cek_akun = mysqli_query($koneksi, "SELECT id FROM users
        WHERE id = $user_id AND role = 'siswa'
        AND id NOT IN (SELECT user_id FROM siswa WHERE user_id IS NOT NULL AND id != $id)");
    if (mysqli_num_rows($cek_akun) == 0) {
        header("location:daftar_siswa_admin.php?pesan=akun");
        exit;
    }
    $user_sql = $user_id;
}

if ($id == 0) {
    $hasil = mysqli_query($koneksi, "INSERT INTO siswa (nis, nama, kelas, jenis_kelamin, user_id)
        VALUES ('$nis', '$nama', '$kelas', '$jk', $user_sql)");
    $pesan = "tambah";
} else {
    $hasil = mysqli_query($koneksi, "UPDATE siswa SET nis = '$nis', nama = '$nama', kelas = '$kelas',
        jenis_kelamin = '$jk', user_id = $user_sql WHERE id = $id");
    $pesan = "edit";
}

if (!$hasil) {
    $pesan = "gagal";
}
header("location:daftar_siswa_admin.php?pesan=$pesan");