<?php
require_once 'koneksi.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$role = strtolower(trim($_POST['role'] ?? ''));

// Periksa role
if (!in_array($role, ['admin', 'guru', 'siswa'])) {
    die("Role tidak valid");
}

// Simpan data user
$stmt = mysqli_prepare(
    $koneksi,
    "INSERT INTO users (username, password, role)
     VALUES (?, ?, ?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "sss",
    $username,
    $password,
    $role
);

if (!mysqli_stmt_execute($stmt)) {
    die("Gagal menyimpan user: " . mysqli_stmt_error($stmt));
}

$user_id = mysqli_insert_id($koneksi);

// Simpan data siswa
if ($role == 'siswa') {

    $nis = trim($_POST['nis'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $kelas = trim($_POST['kelas'] ?? '');
    $jk = $_POST['jenis_kelamin'] ?? '';

    if ($jk == 'Laki-laki') {
        $jk = 'L';
    } elseif ($jk == 'Perempuan') {
        $jk = 'P';
    }

    $stmt = mysqli_prepare(
        $koneksi,
        "INSERT INTO siswa
        (user_id, nis, nama, kelas, jenis_kelamin)
        VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "issss",
        $user_id,
        $nis,
        $nama,
        $kelas,
        $jk
    );

    if (!mysqli_stmt_execute($stmt)) {
        die("Gagal menyimpan siswa: " . mysqli_stmt_error($stmt));
    }
}

// Simpan data guru
elseif ($role == 'guru') {

    $nip = trim($_POST['nip'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $jk = $_POST['jenis_kelamin'] ?? '';

    if ($jk == 'Laki-laki') {
        $jk = 'L';
    } elseif ($jk == 'Perempuan') {
        $jk = 'P';
    }

    $stmt = mysqli_prepare(
        $koneksi,
        "INSERT INTO guru
        (user_id, nip, nama, jenis_kelamin)
        VALUES (?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "isss",
        $user_id,
        $nip,
        $nama,
        $jk
    );

    if (!mysqli_stmt_execute($stmt)) {
        die("Gagal menyimpan guru: " . mysqli_stmt_error($stmt));
    }
}

// Notifikasi setelah berhasil disimpan
if ($role == 'guru') {
    $pesan = 'Data guru berhasil ditambahkan!';
    $tujuan = 'daftar_guru.php';

} elseif ($role == 'siswa') {
    $pesan = 'Data siswa berhasil ditambahkan!';
    $tujuan = 'daftar_siswa.php';

} else {
    $pesan = 'Data admin berhasil ditambahkan!';
    $tujuan = 'daftar_user.php';
}

echo '<script>';
echo 'alert(' . json_encode($pesan) . ');';
echo 'window.location.href = ' . json_encode($tujuan) . ';';
echo '</script>';
exit;
?>