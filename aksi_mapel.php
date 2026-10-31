<?php
include 'koneksi.php';
include 'auth.php';
if ($_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}
mysqli_report(MYSQLI_REPORT_OFF);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("location:kelola_mapel.php");
    exit;
}

$aksi = $_POST['aksi'];
$id = intval($_POST['id']);

// ===== HAPUS =====
if ($aksi == 'hapus') {
    $hasil = mysqli_query($koneksi, "DELETE FROM mapel WHERE id = $id");
    if ($hasil) {
        header("location:kelola_mapel.php?pesan=hapus");
    } else {
        header("location:kelola_mapel.php?pesan=gagal");
    }
    exit;
}

// ===== SIMPAN (tambah / edit) =====
$kode_asli = trim($_POST['kode_mapel']);
$kode = mysqli_real_escape_string($koneksi, $kode_asli);
$nama = mysqli_real_escape_string($koneksi, trim($_POST['nama_mapel']));
$guru_id = intval($_POST['guru_id']);

if ($kode == '' || $nama == '') {
    header("location:kelola_mapel.php?pesan=kosong");
    exit;
}

// kolom kode_mapel di database maksimal 10 karakter
if (strlen($kode_asli) > 10) {
    header("location:kelola_mapel.php?pesan=panjang");
    exit;
}

// cek kode mapel sudah dipakai atau belum
$cek = mysqli_query($koneksi, "SELECT id FROM mapel WHERE kode_mapel = '$kode' AND id != $id");
if (mysqli_num_rows($cek) > 0) {
    header("location:kelola_mapel.php?pesan=kembar");
    exit;
}

// cek guru pengampu (0 = belum ada)
if ($guru_id == 0) {
    $guru_sql = "NULL";
} else {
    $cek_guru = mysqli_query($koneksi, "SELECT id FROM guru WHERE id = $guru_id");
    if (mysqli_num_rows($cek_guru) == 0) {
        header("location:kelola_mapel.php?pesan=gagal");
        exit;
    }
    $guru_sql = $guru_id;
}

if ($id == 0) {
    $hasil = mysqli_query($koneksi, "INSERT INTO mapel (kode_mapel, nama_mapel, guru_id)
        VALUES ('$kode', '$nama', $guru_sql)");
    $pesan = "tambah";
} else {
    $hasil = mysqli_query($koneksi, "UPDATE mapel SET kode_mapel = '$kode', nama_mapel = '$nama',
        guru_id = $guru_sql WHERE id = $id");
    $pesan = "edit";
}

if (!$hasil) {
    $pesan = "gagal";
}
header("location:kelola_mapel.php?pesan=$pesan");