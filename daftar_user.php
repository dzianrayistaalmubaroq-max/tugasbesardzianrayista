<?php
require_once 'koneksi.php';

// Sertakan navbar jika tersedia
if (file_exists('navbar.php')) {
    require_once 'navbar.php';
}

// Ambil seluruh data user
$data = [];

$sql = "SELECT
            u.id,
            u.username,
            u.role,
            COALESCE(s.nama, g.nama, '-') AS nama
        FROM users u
        LEFT JOIN siswa s ON u.id = s.user_id
        LEFT JOIN guru g ON u.id = g.user_id
        ORDER BY u.id DESC";

$hasil = mysqli_query($koneksi, $sql);

if (!$hasil) {
    die("Gagal mengambil data user: " . mysqli_error($koneksi));
}

while ($baris = mysqli_fetch_assoc($hasil)) {
    $data[] = $baris;
}
?>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">

            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Tabel Data User</h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (!empty($data)): ?>
                                    <?php $no = 1; ?>

                                    <?php foreach ($data as $user): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>

                                            <td>
                                                <?php
                                                $username = trim(
                                                    (string) ($user['username'] ?? '')
                                                );

                                                if ($username !== '') {
                                                    echo htmlspecialchars($username);
                                                } else {
                                                    echo '<span class="text-danger">Username kosong</span>';
                                                }
                                                ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    $user['role'] ?? '-'
                                                ) ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars(
                                                    $user['nama'] ?? '-'
                                                ) ?>
                                            </td>

                                            <td>
                                                <a
                                                    href="form_edit_user.php?id=<?= (int) $user['id'] ?>&role=<?= urlencode($user['role']) ?>"
                                                    class="btn btn-warning btn-sm mb-1">
                                                    Edit
                                                </a>

                                                <a
                                                    href="aksi_hapus.php?id=<?= (int) $user['id'] ?>&role=<?= urlencode($user['role']) ?>"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"
                                                    class="btn btn-danger btn-sm mb-1">
                                                    Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            Belum ada data user.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
if (file_exists('footer.php')) {
    require_once 'footer.php';
}
?>