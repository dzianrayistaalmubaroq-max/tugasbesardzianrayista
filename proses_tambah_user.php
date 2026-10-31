<?php
if (isset($_GET['status']) && $_GET['status'] == 'berhasil') {
    echo "<script>alert(' Data berhasil disimpan!');</script>";
}
include "navbar.php";
?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header">
          Form Tambah User
        </div>
        <div class="card-body">
          <form action="proses_tambah_user.php" method="POST">

            <h5 class="mb-3">Data Kredensial Akun</h5>

            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username"
                     placeholder="Contoh: ujang123" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password Akun</label>
              <input type="password" class="form-control" id="password" name="password"
                     placeholder="Contoh: password123" required>
            </div>

            <!-- PILIH ROLE — BISA DIUBAH BEBAS ✅ -->
            <div class="mb-3">
              <label class="form-label">Role</label>
              <select name="role" id="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin">Admin</option>
                <option value="guru">Guru</option>
                <option value="siswa">Siswa</option>
              </select>
            </div>

            <!-- FORM DATA SISWA -->
            <div id="form_siswa" class="d-none">
              <h5 class="mb-3">Data Siswa</h5>
              <div class="mb-3">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-control" placeholder="Masukkan NIS">
              </div>
              <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama">
              </div>
              <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control" placeholder="Contoh: X-RPL-1">
              </div>
              <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin_siswa" class="form-control">
                  <option value="">-- Pilih --</option>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
            </div>

            <!-- FORM DATA GURU -->
            <div id="form_guru" class="d-none">
              <h5 class="mb-3">Data Guru</h5>
              <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP">
              </div>
              <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_guru" class="form-control" placeholder="Masukkan nama">
              </div>
              <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin_guru" class="form-control">
                  <option value="">-- Pilih --</option>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
            </div>

            <!-- FORM DATA ADMIN -->
            <div id="form_admin" class="d-none">
              <div class="alert alert-info">
                Admin tidak memerlukan data tambahan.
              </div>
            </div>

            <div class="d-flex gap-2 mt-4">
              <button type="submit" class="btn btn-primary">Simpan Data</button>
              <a href="tabel.php" class="btn btn-secondary">Kembali</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const role = document.getElementById('role');
const formSiswa = document.getElementById('form_siswa');
const formGuru = document.getElementById('form_guru');
const formAdmin = document.getElementById('form_admin');

function ubahForm() {
  // Sembunyikan SEMUA dulu
  formSiswa.classList.add('d-none');
  formGuru.classList.add('d-none');
  formAdmin.classList.add('d-none');

  // Tampilkan yang dipilih
  if (role.value === 'siswa') {
    formSiswa.classList.remove('d-none');
  } else if (role.value === 'guru') {
    formGuru.classList.remove('d-none');
  } else if (role.value === 'admin') {
    formAdmin.classList.remove('d-none');
  }
}

// Jalankan saat pilih & saat halaman dibuka
role.addEventListener('change', ubahForm);
ubahForm();
</script>

<?php include "script.php"; ?>
