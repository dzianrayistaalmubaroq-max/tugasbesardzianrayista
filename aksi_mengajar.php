<?php
include 'koneksi.php';
include 'auth.php';
if ($_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}
mysqli_report(MYSQLI_REPORT_OFF);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("location:kelola_mengajar.php");
    exit;
}

$aksi = $_POST['aksi'];
$id = intval($_POST['id']);

// ===== HAPUS =====
if ($aksi == 'hapus') {
    $hasil = mysqli_query($koneksi, "DELETE FROM mengajar WHERE id = $id");
    if ($hasil) {
        header("location:kelola_mengajar.php?pesan=hapus");
    } else {
        header("location:kelola_mengajar.php?pesan=gagal");
    }
    exit;
}

// ===== SIMPAN (tambah / edit) =====
$id_guru = intval($_POST['id_guru']);
$id_mapel = intval($_POST['id_mapel']);
$kelas = mysqli_real_escape_string($koneksi, trim($_POST['kelas']));
$hari = mysqli_real_escape_string($koneksi, $_POST['hari']);
$mulai = mysqli_real_escape_string($koneksi, $_POST['jam_mulai']);
$selesai = mysqli_real_escape_string($koneksi, $_POST['jam_selesai']);


if ($id_guru == 0 || $id_mapel == 0 || $kelas == '' || $mulai == '' || $selesai == '') {
    header("location:kelola_mengajar.php?pesan=kosong");
    exit;
}

// hari harus salah satu dari Senin sampai Sabtu
if ($hari != 'Senin' && $hari != 'Selasa' && $hari != 'Rabu' && $hari != 'Kamis' && $hari != 'Jumat' && $hari != 'Sabtu') {
    header("location:kelola_mengajar.php?pesan=kosong");
    exit;
}

if ($selesai <= $mulai) {
    header("location:kelola_mengajar.php?pesan=jam");
    exit;
}

// cek bentrok: guru atau kelas yang sama di hari dan jam yang beririsan
$cek = mysqli_query($koneksi, "SELECT id FROM mengajar
    WHERE id != $id AND hari = '$hari'
    AND (id_guru = $id_guru OR kelas = '$kelas')
    AND jam_mulai < '$selesai' AND jam_selesai > '$mulai'");
if (mysqli_num_rows($cek) > 0) {
    header("location:kelola_mengajar.php?pesan=bentrok");
    exit;
}

if ($id == 0) {
    $hasil = mysqli_query($koneksi, "INSERT INTO mengajar (id_guru, id_mapel, kelas, hari, jam_mulai, jam_selesai)
        VALUES ($id_guru, $id_mapel, '$kelas', '$hari', '$mulai', '$selesai')");
    $pesan = "tambah";
} else {
    $hasil = mysqli_query($koneksi, "UPDATE mengajar SET id_guru = $id_guru, id_mapel = $id_mapel,
        kelas = '$kelas', hari = '$hari', jam_mulai = '$mulai', jam_selesai = '$selesai' WHERE id = $id");
    $pesan = "edit";
}

if (!$hasil) {
    $pesan = "gagal";
}
header("location:kelola_mengajar.php?pesan=$pesan");