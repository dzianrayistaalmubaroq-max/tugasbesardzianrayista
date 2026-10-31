<?php
require_once 'koneksi.php';

if (!isset($_GET['role']) || !isset($_GET['id'])) {
    die("ID atau Role tidak ditemukan! Silakan kembali ke tabel user dan klik Edit.");
}

$id = (int) $_GET['id'];
$role = strtolower($_GET['role']);

if ($id <= 0) {
    die("ID tidak valid!");
}

if ($role != 'admin' && $role != 'guru' && $role != 'siswa') {
    die("Role tidak valid!");
}

if ($role == 'admin') {
    $sql = "SELECT * FROM users WHERE id = $id";
    $admin = mysqli_fetch_assoc(mysqli_query($koneksi, $sql));

    if (!$admin) {
        die("Data admin tidak ditemukan!");
    }

} elseif ($role == 'guru') {
    $sql = "SELECT users.id AS user_id, users.username,
            users.password, users.role,
            guru.id AS guru_id, guru.nip, guru.nama,
            guru.jenis_kelamin
            FROM users
            JOIN guru ON users.id = guru.user_id
            WHERE users.id = $id";

    $guru = mysqli_fetch_assoc(mysqli_query($koneksi, $sql));

    if (!$guru) {
        die("Data guru tidak ditemukan!");
    }

} elseif ($role == 'siswa') {
    $sql = "SELECT users.id AS user_id, users.username,
            users.password, users.role,
            siswa.id AS siswa_id, siswa.nis, siswa.nama,
            siswa.kelas, siswa.jenis_kelamin
            FROM users
            JOIN siswa ON users.id = siswa.user_id
            WHERE users.id = $id";

    $siswa = mysqli_fetch_assoc(mysqli_query($koneksi, $sql));

    if (!$siswa) {
        die("Data siswa tidak ditemukan!");
    }
}

require_once 'navbar.php';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 mt-4">

            <div class="card">
                <div class="card-header">
                    <h3>Form Edit User (<?= ucfirst($role) ?>)</h3>
                </div>

                <div class="card-body">

<?php if ($role == 'admin') { ?>

                    <form action="aksi_edit_user.php?aksi=editadmin"
                          method="POST">

                        <h4>Data Kredensial Akun</h4>

                        <div class="mb-3">
                            <label class="form-label">Username:</label>
                            <input type="text" class="form-control"
                                   name="username"
                                   value="<?= htmlspecialchars($admin['username']) ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Akun:</label>
                            <input type="password" class="form-control"
                                   name="password"
                                   placeholder="Kosongkan jika tidak diubah">
                        </div>

                        <input type="hidden" name="role" value="admin">
                        <input type="hidden" name="id"
                               value="<?= $admin['id'] ?>">

                        <button type="submit" class="btn btn-primary">
                            Simpan Data
                        </button>

                        <a href="tabel.php" class="btn btn-secondary">
                            Kembali
                        </a>
                    </form>

<?php } elseif ($role == 'guru') { ?>

                    <form action="aksi_edit_user.php?aksi=editguru"
                          method="POST">

                        <h4>Data Profil Guru</h4>

                        <div class="mb-3">
                            <label class="form-label">NIP:</label>
                            <input type="text" class="form-control"
                                   name="nip"
                                   value="<?= htmlspecialchars($guru['nip']) ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap:</label>
                            <input type="text" class="form-control"
                                   name="nama"
                                   value="<?= htmlspecialchars($guru['nama']) ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">
                                Jenis Kelamin:
                            </label>

                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio" name="jenis_kelamin"
                                       id="laki" value="L"
                                       <?= $guru['jenis_kelamin'] == 'L' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="laki">
                                    Laki-laki
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio" name="jenis_kelamin"
                                       id="perempuan" value="P"
                                       <?= $guru['jenis_kelamin'] == 'P' ? 'checked' : '' ?>>
                                <label class="form-check-label"
                                       for="perempuan">Perempuan</label>
                            </div>
                        </div>

                        <hr>
                        <h4>Data Kredensial Akun</h4>

                        <div class="mb-3">
                            <label class="form-label">Username:</label>
                            <input type="text" class="form-control"
                                   name="username"
                                   value="<?= htmlspecialchars($guru['username']) ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Akun:</label>
                            <input type="password" class="form-control"
                                   name="password"
                                   placeholder="Kosongkan jika tidak diubah">
                        </div>

                        <input type="hidden" name="role" value="guru">
                        <input type="hidden" name="id"
                               value="<?= $guru['guru_id'] ?>">
                        <input type="hidden" name="user_id"
                               value="<?= $guru['user_id'] ?>">

                        <button type="submit" class="btn btn-primary">
                            Simpan Data
                        </button>

                        <a href="tabel.php" class="btn btn-secondary">
                            Kembali
                        </a>
                    </form>

<?php } elseif ($role == 'siswa') { ?>

                    <form action="aksi_edit_user.php?aksi=editsiswa"
                          method="POST">

                        <h4>Data Profil Siswa</h4>

                        <div class="mb-3">
                            <label class="form-label">NIS:</label>
                            <input type="text" class="form-control"
                                   name="nis"
                                   value="<?= htmlspecialchars($siswa['nis']) ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap:</label>
                            <input type="text" class="form-control"
                                   name="nama"
                                   value="<?= htmlspecialchars($siswa['nama']) ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kelas:</label>
                            <input type="text" class="form-control"
                                   name="kelas"
                                   value="<?= htmlspecialchars($siswa['kelas']) ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">
                                Jenis Kelamin:
                            </label>

                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio" name="jenis_kelamin"
                                       id="laki" value="L"
                                       <?= $siswa['jenis_kelamin'] == 'L' ? 'checked' : '' ?>>
                                <label class="form-check-label" for="laki">
                                    Laki-laki
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio" name="jenis_kelamin"
                                       id="perempuan" value="P"
                                       <?= $siswa['jenis_kelamin'] == 'P' ? 'checked' : '' ?>>
                                <label class="form-check-label"
                                       for="perempuan">Perempuan</label>
                            </div>
                        </div>

                        <hr>
                        <h4>Data Kredensial Akun</h4>

                        <div class="mb-3">
                            <label class="form-label">Username:</label>
                            <input type="text" class="form-control"
                                   name="username"
                                   value="<?= htmlspecialchars($siswa['username']) ?>"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Akun:</label>
                            <input type="password" class="form-control"
                                   name="password"
                                   placeholder="Kosongkan jika tidak diubah">
                        </div>

                        <input type="hidden" name="role" value="siswa">
                        <input type="hidden" name="id"
                               value="<?= $siswa['siswa_id'] ?>">
                        <input type="hidden" name="user_id"
                               value="<?= $siswa['user_id'] ?>">

                        <button type="submit" class="btn btn-primary">
                            Simpan Data
                        </button>

                        <a href="tabel.php" class="btn btn-secondary">
                            Kembali
                        </a>
                    </form>

<?php } ?>

                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
