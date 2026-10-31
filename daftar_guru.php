<?php
require_once 'koneksi.php';
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Daftar Guru</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>

<?php
require_once 'navbar.php';
?>

<?php
$sql = "SELECT users.*, guru.nama
        FROM users
        INNER JOIN guru ON users.id = guru.user_id
        WHERE users.role = 'guru'
        ORDER BY users.id DESC";

$hasil = mysqli_query($koneksi, $sql);
?>

<div class="container mt-4">

    <div class="card">

        <div class="card-header">
            <h3>Daftar Guru</h3>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php
                    $no = 1;

                    while ($data = mysqli_fetch_assoc($hasil)) {
                    ?>

                        <tr>
                            <td><?= $no++; ?></td>

                            <td>
                                <?= htmlspecialchars($data['username'] ?? ''); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($data['role']); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($data['nama']); ?>
                            </td>

                            <td>
                                <a
                                    href="aksi_edit_user.php?id=<?= $data['id']; ?>"
                                    class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <a
                                    href="aksi_hapus.php?id=<?= $data['id']; ?>&role=guru"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus data guru?')">
                                    Hapus
                                </a>
                            </td>
                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>