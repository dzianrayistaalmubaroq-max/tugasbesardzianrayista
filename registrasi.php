<?php
require_once 'auth.php';
require_once 'koneksi.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$error = '';

$role = $_POST['role'] ?? 'siswa';

if (!in_array($role, ['siswa', 'guru'], true)) {
    $role = 'siswa';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $nama     = trim($_POST['nama_lengkap'] ?? '');
    $jk       = $_POST['jenis_kelamin'] ?? '';

    $nis   = trim($_POST['nis'] ?? '');
    $nip   = trim($_POST['nip'] ?? '');
    $kelas = trim($_POST['kelas'] ?? '');

    // Validasi sesuai jenis user
    if ($username === '' || $password === '' || $nama === '' || $jk === '') {
        $error = "Semua kolom wajib diisi.";
    } elseif ($role === 'siswa' &&
              ($nis === '' || $kelas === '')) {
        $error = "NIS dan kelas wajib diisi.";
    } elseif ($role === 'guru' && $nip === '') {
        $error = "NIP wajib diisi.";
    } elseif (!in_array($jk, ['L', 'P'], true)) {
        $error = "Jenis kelamin tidak valid.";
    } else {
        try {
            // Periksa username
            $stmt = mysqli_prepare(
                $koneksi,
                "SELECT id FROM users WHERE username = ?"
            );

            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);

            $hasil = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($hasil) > 0) {
                $error = "Username sudah dipakai.";
            } else {
                mysqli_begin_transaction($koneksi);

                try {
                    // Simpan akun
                    $hash = password_hash(
                        $password,
                        PASSWORD_DEFAULT
                    );

                    $stmt = mysqli_prepare(
                        $koneksi,
                        "INSERT INTO users (username, password, role)
                         VALUES (?, ?, ?)"
                    );

                    mysqli_stmt_bind_param(
                        $stmt,
                        "sss",
                        $username,
                        $hash,
                        $role
                    );

                    mysqli_stmt_execute($stmt);

                    $uid = mysqli_insert_id($koneksi);

                    // Simpan profil sesuai role
                    if ($role === 'siswa') {
                        $stmt = mysqli_prepare(
                            $koneksi,
                            "INSERT INTO siswa
                             (user_id, nis, nama, kelas, jenis_kelamin)
                             VALUES (?, ?, ?, ?, ?)"
                        );

                        mysqli_stmt_bind_param(
                            $stmt,
                            "issss",
                            $uid,
                            $nis,
                            $nama,
                            $kelas,
                            $jk
                        );

                        mysqli_stmt_execute($stmt);

                    } else {
                        $stmt = mysqli_prepare(
                            $koneksi,
                            "INSERT INTO guru
                             (user_id, nip, nama, jenis_kelamin)
                             VALUES (?, ?, ?, ?)"
                        );

                        mysqli_stmt_bind_param(
                            $stmt,
                            "isss",
                            $uid,
                            $nip,
                            $nama,
                            $jk
                        );

                        mysqli_stmt_execute($stmt);
                    }

                    mysqli_commit($koneksi);

                    header(
                        "Location: login.php?pesan=" .
                        urlencode("Registrasi berhasil, silakan login.")
                    );
                    exit;

                } catch (Throwable $e) {
                    mysqli_rollback($koneksi);

                    error_log($e->getMessage());
                    $error = "Registrasi gagal. Periksa struktur tabel database.";
                }
            }

        } catch (Throwable $e) {
            error_log($e->getMessage());
            $error = "Terjadi kesalahan saat memproses registrasi.";
        }
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Form Register User</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col-lg-2 d-none d-lg-block"></div>

        <div class="col-12 col-lg-8">

            <div class="card">
                <div class="card-header">
                    <b>Form Register User (Siswa/Guru)</b>
                </div>

                <div class="card-body">

                    <?php if ($error !== ''): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form action="registrasi.php" method="POST">

                        <h4>Jenis Pengguna</h4>

                        <div class="mb-3">
                            <label class="form-label">
                                Daftar Sebagai:
                            </label>

                            <select name="role" id="role"
                                    class="form-select" required>
                                <option value="siswa"
                                    <?= $role === 'siswa' ? 'selected' : '' ?>>
                                    Siswa
                                </option>

                                <option value="guru"
                                    <?= $role === 'guru' ? 'selected' : '' ?>>
                                    Guru
                                </option>
                            </select>
                        </div>

                        <hr>

                        <h4>Data Profil User</h4>

                        <!-- Data siswa -->
                        <div id="formSiswa">

                            <div class="mb-3">
                                <label class="form-label">NIS:</label>

                                <input type="text" name="nis"
                                       id="nis" class="form-control"
                                       value="<?= htmlspecialchars($nis ?? '') ?>"
                                       placeholder="Nomor Induk Siswa">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kelas:</label>

                                <input type="text" name="kelas"
                                       id="kelas" class="form-control"
                                       value="<?= htmlspecialchars($kelas ?? '') ?>"
                                       placeholder="Contoh: XI-RPL-1">
                            </div>

                        </div>

                        <!-- Data guru -->
                        <div id="formGuru">

                            <div class="mb-3">
                                <label class="form-label">NIP:</label>

                                <input type="text" name="nip"
                                       id="nip" class="form-control"
                                       value="<?= htmlspecialchars($nip ?? '') ?>"
                                       placeholder="Nomor Induk Pegawai">
                            </div>

                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Nama Lengkap:
                            </label>

                            <input type="text" name="nama_lengkap"
                                   class="form-control"
                                   value="<?= htmlspecialchars($nama ?? '') ?>"
                                   placeholder="Masukkan nama lengkap"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Jenis Kelamin:
                            </label>

                            <div>
                                <input type="radio" name="jenis_kelamin"
                                       value="L" class="form-check-input"
                                       id="jkL"
                                       <?= ($jk ?? '') === 'L' ? 'checked' : '' ?>
                                       required>

                                <label for="jkL">Laki-laki</label>
                            </div>

                            <div>
                                <input type="radio" name="jenis_kelamin"
                                       value="P" class="form-check-input"
                                       id="jkP"
                                       <?= ($jk ?? '') === 'P' ? 'checked' : '' ?>>

                                <label for="jkP">Perempuan</label>
                            </div>
                        </div>

                        <hr>

                        <h4>Data Kredensial Akun</h4>

                        <div class="mb-3">
                            <label class="form-label">Username:</label>

                            <input type="text" name="username"
                                   class="form-control"
                                   value="<?= htmlspecialchars($username ?? '') ?>"
                                   placeholder="Masukkan username"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Password Akun:
                            </label>

                            <input type="password" name="password"
                                   class="form-control"
                                   placeholder="Masukkan password"
                                   required>
                        </div>

                        <button type="submit"
                                class="btn btn-primary">
                            Simpan Data
                        </button>

                        <a href="login.php"
                           class="btn btn-secondary">
                            Kembali
                        </a>

                    </form>

                </div>
            </div>

        </div>

        <div class="col-lg-2 d-none d-lg-block"></div>
    </div>
</div>

<script>
function aturForm() {
    const role = document.getElementById('role').value;

    const formSiswa = document.getElementById('formSiswa');
    const formGuru = document.getElementById('formGuru');

    const nis = document.getElementById('nis');
    const kelas = document.getElementById('kelas');
    const nip = document.getElementById('nip');

    if (role === 'siswa') {
        formSiswa.style.display = 'block';
        formGuru.style.display = 'none';

        nis.required = true;
        kelas.required = true;
        nip.required = false;

        nip.disabled = true;
        nis.disabled = false;
        kelas.disabled = false;

    } else {
        formSiswa.style.display = 'none';
        formGuru.style.display = 'block';

        nis.required = false;
        kelas.required = false;
        nip.required = true;

        nis.disabled = true;
        kelas.disabled = true;
        nip.disabled = false;
    }
}

document.getElementById('role').addEventListener('change', aturForm);

aturForm();
</script>

</body>
</html>