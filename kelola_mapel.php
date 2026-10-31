<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit;
}
include "koneksi.php";
include "navbar.php";

if (isset($_POST['tambah'])) {
  $kode = $_POST['kode_mapel'];
  $nama = $_POST['nama_mapel'];
  $guru = $_POST['guru_id'];
  mysqli_query($koneksi, "INSERT INTO tb_mapel (kode_mapel, nama_mapel, guru_id) VALUES ('$kode', '$nama', '$guru')");
  header("Location: kelola_mapel.php");
}

if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  mysqli_query($koneksi, "DELETE FROM tb_mapel WHERE id='$id'");
  header("Location: kelola_mapel.php");
}

$data = mysqli_query($koneksi, "SELECT m.*, g.nama AS nama_guru FROM tb_mapel m LEFT JOIN tb_guru g ON m.guru_id = g.id");
$guru_list = mysqli_query($koneksi, "SELECT * FROM tb_guru");
?>

<div class="container mt-4">
  <h5>Mata Pelajaran</h5><hr>

  <form method="POST" class="card p-3 mb-4">
    <div class="row g-2">
      <div class="col">
        <input type="text" name="kode_mapel" class="form-control" placeholder="Kode Mapel" required>
      </div>
      <div class="col">
        <input type="text" name="nama_mapel" class="form-control" placeholder="Nama Mapel" required>
      </div>
      <div class="col">
        <select name="guru_id" class="form-select" required>
          <option value="">Pilih Guru Pengampu</option>
          <?php while ($g = mysqli_fetch_assoc($guru_list)): ?>
          <option value="<?= $g['id'] ?>"><?= $g['nama'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col">
        <button type="submit" name="tambah" class="btn btn-primary w-100">Tambah</button>
      </div>
    </div>
  </form>

  <table class="table table-bordered">
    <tr class="table-dark">
      <th>No</th>
      <th>Kode</th>
      <th>Nama Mapel</th>
      <th>Guru Pengampu</th>
      <th>Aksi</th>
    </tr>
    <?php $no = 1; while ($r = mysqli_fetch_assoc($data)): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= $r['kode_mapel'] ?></td>
      <td><?= $r['nama_mapel'] ?></td>
      <td><?= $r['nama_guru'] ?? '-' ?></td>
      <td>
        <a href="?hapus=<?= $r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

</body>
</html>
