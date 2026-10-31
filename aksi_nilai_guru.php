<?php
include 'auth_guru.php';
mysqli_report(MYSQLI_REPORT_OFF);

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("location:nilai_guru.php");
    exit;
}

if ($id_guru == 0) {
    header("location:nilai_guru.php?pesan=akun");
    exit;
}

$aksi = $_POST['aksi'];
$id = intval($_POST['id']);

// ===== HAPUS (hanya nilai dari mapel milik guru ini) =====
if ($aksi == 'hapus') {
    mysqli_query($koneksi, "DELETE nr FROM nilai_rapor nr
        JOIN mapel m ON m.id = nr.mapel_id
        WHERE nr.id = $id AND m.guru_id = $id_guru");
    if (mysqli_affected_rows($koneksi) > 0) {
        header("location:nilai_guru.php?pesan=hapus");
    } else {
        header("location:nilai_guru.php?pesan=gagal");
    }
    exit;
}

// ===== SIMPAN (tambah / edit) =====
$siswa_id = intval($_POST['siswa_id']);
$mapel_id = intval($_POST['mapel_id']);
$kkm_asli = trim($_POST['nilai_kkm']);
$p_asli = trim($_POST['nilai_pengetahuan']);
$k_asli = trim($_POST['nilai_keterampilan']);

if ($siswa_id == 0 || $mapel_id == 0) {
    header("location:nilai_guru.php?pesan=kosong");
    exit;
}

// KKM dan nilai harus angka 0 sampai 100
if (!is_numeric($kkm_asli) || !is_numeric($p_asli) || !is_numeric($k_asli)) {
    header("location:nilai_guru.php?pesan=angka");
    exit;
}
$kkm = intval($kkm_asli);
$pengetahuan = intval($p_asli);
$keterampilan = intval($k_asli);

if ($kkm < 0 || $kkm > 100 || $pengetahuan < 0 || $pengetahuan > 100 || $keterampilan < 0 || $keterampilan > 100) {
    header("location:nilai_guru.php?pesan=angka");
    exit;
}

// mapel harus milik guru ini
$cek_mapel = mysqli_query($koneksi, "SELECT id FROM mapel WHERE id = $mapel_id AND guru_id = $id_guru");
if (mysqli_num_rows($cek_mapel) == 0) {
    header("location:nilai_guru.php?pesan=mapel");
    exit;
}

// siswa harus ada
$cek_siswa = mysqli_query($koneksi, "SELECT id FROM siswa WHERE id = $siswa_id");
if (mysqli_num_rows($cek_siswa) == 0) {
    header("location:nilai_guru.php?pesan=kosong");
    exit;
}

// kalau edit, nilai yang diedit harus dari mapel milik guru ini
if ($id > 0) {
    $cek_milik = mysqli_query($koneksi, "SELECT nilai_rapor.id FROM nilai_rapor
        JOIN mapel ON mapel.id = nilai_rapor.mapel_id
        WHERE nilai_rapor.id = $id AND mapel.guru_id = $id_guru");
    if (mysqli_num_rows($cek_milik) == 0) {
        header("location:nilai_guru.php?pesan=gagal");
        exit;
    }
}

// satu siswa hanya punya satu nilai untuk tiap mapel
$cek_kembar = mysqli_query($koneksi, "SELECT id FROM nilai_rapor
    WHERE siswa_id = $siswa_id AND mapel_id = $mapel_id AND id != $id");
if (mysqli_num_rows($cek_kembar) > 0) {
    header("location:nilai_guru.php?pesan=kembar");
    exit;
}

// keterangan otomatis
$rata = ($pengetahuan + $keterampilan) / 2;
if ($rata >= $kkm) {
    $keterangan = "Tuntas";
} else {
    $keterangan = "Belum Tuntas";
}

if ($id == 0) {
    $hasil = mysqli_query($koneksi, "INSERT INTO nilai_rapor
        (siswa_id, mapel_id, nilai_kkm, nilai_pengetahuan, nilai_keterampilan, Keterangan)
        VALUES ($siswa_id, $mapel_id, $kkm, $pengetahuan, $keterampilan, '$keterangan')");
    $pesan = "tambah";
} else {
    $hasil = mysqli_query($koneksi, "UPDATE nilai_rapor SET siswa_id = $siswa_id, mapel_id = $mapel_id,
        nilai_kkm = $kkm, nilai_pengetahuan = $pengetahuan, nilai_keterampilan = $keterampilan,
        Keterangan = '$keterangan' WHERE id = $id");
    $pesan = "edit";
}

if (!$hasil) {
    $pesan = "gagal";
}
header("location:nilai_guru.php?pesan=$pesan");