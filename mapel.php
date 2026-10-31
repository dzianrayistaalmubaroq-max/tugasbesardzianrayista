<?php
require_once 'koneksi.php';
require_once 'navbar.php';

$sql = "SELECT * FROM mapel ORDER BY id DESC";
$hasil = mysqli_query($koneksi, $sql);
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <b>Daftar Mata Pelajaran</b>
        </div>

        <div class="card-body">
            <a href="tambah_mapel.php" class="btn btn-primary mb-3">
                Tambah Mapel
            </a>

            <table class="table table-bordered table-striped">
                <tr>
                    <th>No</th>
                    <th>Nama Mapel</th>
                    <th>Aksi</th>
                </tr>

                <?php
                $no = 1;
                while ($baris = mysqli_fetch_assoc($hasil)) {
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($baris['kode_mapel']) ?></td>
                    <td><?= htmlspecialchars($baris['nama_mapel']) ?></td>
                    <td>
                        <a href="aksi_hapus_mapel.php?id=<?= $baris['id'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Hapus mapel ini?')">
                            Hapus
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
