<?php
require_once 'koneksi.php';
require_once 'navbar.php';

$guru = mysqli_query($koneksi, "SELECT id, nama FROM guru ORDER BY nama");
$mapel = mysqli_query($koneksi, "SELECT id, nama_mapel FROM mapel ORDER BY nama_mapel");
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <b>Form Mengajar</b>
                </div>

                <div class="card-body">
                    <form action="aksi_tambah_mengajar.php" method="POST">

                        <div class="mb-3">
                            <label>Nama Guru</label>
                            <select name="guru_id" class="form-select" required>
                                <option value="">Pilih Guru</option>
                                <?php while ($g = mysqli_fetch_assoc($guru)) { ?>
                                <option value="<?= $g['id'] ?>">
                                    <?= htmlspecialchars($g['nama']) ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Mata Pelajaran</label>
                            <select name="mapel_id" class="form-select" required>
                                <option value="">Pilih Mapel</option>
                                <?php while ($m = mysqli_fetch_assoc($mapel)) { ?>
                                <option value="<?= $m['id'] ?>">
                                    <?= htmlspecialchars($m['nama_mapel']) ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Kelas</label>
                            <input type="text" name="kelas"
                                   class="form-control"
                                   placeholder="Contoh: XI RPL 1" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>

                        <a href="mengajar.php" class="btn btn-secondary">
                            Kembali
                        </a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
