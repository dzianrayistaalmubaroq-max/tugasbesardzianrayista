<?php
require_once 'koneksi.php';
require_once 'navbar.php';
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <b>Form Tambah Mapel</b>
                </div>

                <div class="card-body">
                    <form action="aksi_tambah_mapel.php" method="POST">
                        <div class="mb-3">
                            <label>Kode Mapel</label>
                            <input type="text" name="kode_mapel"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Nama Mapel</label>
                            <input type="text" name="nama_mapel"
                                   class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>

                        <a href="mapel.php" class="btn btn-secondary">
                            Kembali
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
