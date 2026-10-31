<?php
if (isset($_GET['status']) && $_GET['status'] == 'berhasil') {
    echo "<script>alert('Data berhasil disimpan!');</script>";
}

include "navbar.php";
?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header">
                    <b>Form Register User (Admin/Guru/Siswa)</b>
                </div>

                <div class="card-body">

                    <form action="aksi_tambah_user.php" method="POST">

                        <h4>Jenis Pengguna</h4>

                        <div class="mb-3">
                            <label class="form-label">Daftar Sebagai:</label>

                            <select name="role" id="role"
                                    class="form-select" required>
                                <option value="siswa">Siswa</option>
                                <option value="guru">Guru</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <hr>

                        <!-- DATA PROFIL -->
                        <div id="form_profil">

                            <h4>Data Profil User</h4>

                            <div class="mb-3" id="field_nis">
                                <label class="form-label">NIS:</label>
                                <input type="text" name="nis" id="nis"
                                       class="form-control"
                                       placeholder="Masukkan NIS">
                            </div>

                            <div class="mb-3" id="field_nip">
                                <label class="form-label">NIP:</label>
                                <input type="text" name="nip" id="nip"
                                       class="form-control"
                                       placeholder="Masukkan NIP">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap:</label>
                                <input type="text" name="nama" id="nama"
                                       class="form-control"
                                       placeholder="Masukkan nama lengkap">
                            </div>

                            <div class="mb-3" id="field_kelas">
                                <label class="form-label">Kelas:</label>
                                <input type="text" name="kelas" id="kelas"
                                       class="form-control"
                                       placeholder="Contoh: XI-RPL-1">
                            </div>

                            <div class="mb-3" id="field_jk">
                                <label class="form-label">Jenis Kelamin:</label>

                                <select name="jenis_kelamin" id="jenis_kelamin"
                                        class="form-select">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                        </div>

                        <!-- DATA AKUN -->
                        <hr>

                        <h4>Data Kredensial Akun</h4>

                        <div class="mb-3">
                            <label class="form-label">Username:</label>
                            <input type="text" name="username"
                                   class="form-control"
                                   placeholder="Masukkan username" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password:</label>
                            <input type="password" name="password"
                                   class="form-control"
                                   placeholder="Masukkan password" required>
                        </div>

                        <div id="info_admin" class="alert alert-info"
                             style="display:none;">
                            Admin hanya perlu mengisi username dan password.
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Simpan Data
                        </button>

                        <a href="tabel.php" class="btn btn-secondary">
                            Kembali
                        </a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
const role = document.getElementById('role');

const fieldNis = document.getElementById('field_nis');
const fieldNip = document.getElementById('field_nip');
const fieldKelas = document.getElementById('field_kelas');
const fieldJK = document.getElementById('field_jk');
const formProfil = document.getElementById('form_profil');
const infoAdmin = document.getElementById('info_admin');

const nis = document.getElementById('nis');
const nip = document.getElementById('nip');
const nama = document.getElementById('nama');
const kelas = document.getElementById('kelas');
const jk = document.getElementById('jenis_kelamin');

function aturForm() {

    // Atur tampilan awal
    fieldNis.style.display = 'none';
    fieldNip.style.display = 'none';
    fieldKelas.style.display = 'none';
    fieldJK.style.display = 'none';
    formProfil.style.display = 'block';
    infoAdmin.style.display = 'none';

    // Semua data profil tidak wajib terlebih dahulu
    nis.required = false;
    nip.required = false;
    nama.required = false;
    kelas.required = false;
    jk.required = false;

    if (role.value === 'siswa') {

        fieldNis.style.display = 'block';
        fieldKelas.style.display = 'block';
        fieldJK.style.display = 'block';

        nis.required = true;
        nama.required = true;
        kelas.required = true;
        jk.required = true;

    } else if (role.value === 'guru') {

        fieldNip.style.display = 'block';
        fieldJK.style.display = 'block';

        nip.required = true;
        nama.required = true;
        jk.required = true;

    } else if (role.value === 'admin') {

        formProfil.style.display = 'none';
        infoAdmin.style.display = 'block';
    }
}

role.addEventListener('change', aturForm);

aturForm();
</script>

<?php include "script.php"; ?>