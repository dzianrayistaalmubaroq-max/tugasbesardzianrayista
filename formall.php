<?php
require_once 'navbar.php';

$role     = $_POST['role'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
?>

<div class="container">
    <div class="row align-items-start">

        <div class="col-2"></div>

        <div class="col-8">
            <br>

            <div class="card">
                <div class="card-header">
                    <h3>Form Tambah User</h3>
                </div>

                <div class="card-body">

                    <form method="POST" action="">
                        <h3>Data Kredensial Akun</h3>

                        <div class="mb-3">
                            <label class="form-label">Username Akun:</label>
                            <input type="text" name="username" class="form-control"
                                   placeholder="Masukkan username"
                                   value="<?= htmlspecialchars($username) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Akun:</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Masukkan password" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role:</label>
                            <select name="role" class="form-control" onchange="this.form.submit()" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" <?= $role == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="guru"  <?= $role == 'guru'  ? 'selected' : '' ?>>Guru</option>
                                <option value="siswa" <?= $role == 'siswa' ? 'selected' : '' ?>>Siswa</option>
                            </select>
                        </div>
                    </form>

                    <?php if (!empty($role)): ?>
                    <hr>

                    <form method="POST" action="aksi_tambah_user.php">
                        <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
                        <input type="hidden" name="password" value="<?= htmlspecialchars($password) ?>">
                        <input type="hidden" name="role"     value="<?= htmlspecialchars($role) ?>">

                        <?php if ($role == 'siswa'): ?>
                            <h5>Data Siswa</h5>
                            <div class="mb-3">
                                <input type="text" name="nis" class="form-control" placeholder="NIS" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="nama" class="form-control" placeholder="Nama Siswa" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="kelas" class="form-control" placeholder="Kelas" required>
                            </div>
                            <div class="mb-3">
                                <select name="jenis_kelamin" class="form-control" required>
                                    <option value="">-- Jenis Kelamin --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        <?php endif; ?>

                        <?php if ($role == 'guru'): ?>
                            <h5>Data Guru</h5>
                            <div class="mb-3">
                                <input type="text" name="nip" class="form-control" placeholder="NIP" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="nama" class="form-control" placeholder="Nama Guru" required>
                            </div>
                            <div class="mb-3">
                                <select name="jenis_kelamin" class="form-control" required>
                                    <option value="">-- Jenis Kelamin --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        <?php endif; ?>

                        <?php if ($role == 'admin'): ?>
                            <h5>Data Admin</h5>
                            <p>Admin tidak memerlukan data tambahan.</p>
                        <?php endif; ?>

                        <br>
                        <button type="submit" name="tambah" class="btn btn-primary">Simpan Data</button>
                        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
                    </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
