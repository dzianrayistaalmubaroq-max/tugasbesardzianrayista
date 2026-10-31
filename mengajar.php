<?php
require_once 'koneksi.php';
require_once 'navbar.php';

$sql = "SELECT mengajar.*, guru.nama AS nama_guru,
        mapel.nama_mapel
        FROM mengajar
        LEFT JOIN guru ON mengajar.guru_id = guru.id
        LEFT JOIN mapel ON mengajar.mapel_id = mapel.id
        ORDER BY mengajar.id DESC";

$hasil = mysqli_query($koneksi, $sql);
?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <b>Daftar Mengajar</b>
        </div>

        <div class="card-body">
            <a href="tambah_mengajar.php" class="btn btn-primary mb-3">
                Tambah Mengajar
            </a>

            <table class="table table-bordered table-striped">
                <tr>
                    <th>No</th>
                    <th>Nama Guru</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                </tr>

                <?php
                $no = 1;
                while ($baris = mysqli_fetch_assoc($hasil)) {
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($baris['nama_guru'] ?? '') ?></td>
                    <td><?= htmlspecialchars($baris['nama_mapel'] ?? '') ?></td>
                    <td><?= htmlspecialchars($baris['kelas']) ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
