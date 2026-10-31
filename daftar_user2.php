<?php
include 'koneksi.php';
include 'navbar.php';

$sql = "SELECT * FROM users ORDER BY id DESC";

$hasil = mysqli_query($koneksi, $sql);

$data = [];

if (mysqli_num_rows($hasil) > 0) {
    while ($baris = mysqli_fetch_assoc($hasil)) {
        $data[] = $baris;
    }
}
?>


<div class="container">
  <div class="row align-items-start">
    <div class="col-2">
    </div>

    <div class="col-8">
      <br>

      <!-- awal card -->
      <div class="card">
        <div class="card-header">
          <h3>Tabel</h3>
        </div>

        <div class="card-body">

          <!-- awal tabel -->
          <table class="table">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Username</th>
                <th scope="col">Password</th>
                <th scope="col">Role</th>
                <th scope="col">Create At</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>

            <tbody>

<?php
$no = 1;

for ($i = 0; $i < count($data); $i++) {
?>

              <tr>
                <th scope="row"><?php echo $no++; ?></th>
                <td><?= $data[$i]['username']; ?></td>
                <td><?= $data[$i]['password']; ?></td>
                <td><?= $data[$i]['role']; ?></td>
                <td><?= $data[$i]['created_at']; ?></td>

                <td>
                  <a href="edit_user.php?id=<?= $data[$i]['id']; ?>" 
                     class="btn btn-warning btn-sm">Edit</a>

                  <a href="aksi_hapus.php?id=<?= $data[$i]['id']; ?>&role=<?= $data[$i]['role']; ?>" 
                     class="btn btn-danger btn-sm"
                     onclick="return confirm('Yakin ingin menghapus data ini?')">
                     Hapus
                  </a>
                </td>
              </tr>

<?php
}
?>

            </tbody>
          </table>
          <!-- akhir tabel -->

        </div>
      </div>
      <!-- akhir card -->

    </div>

    <div class="col-2">
    </div>

  </div>
</div>

<?php
require_once('footer.php');
?>