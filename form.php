<?php include "navbar.php"; ?>

<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <b>Form Tambah User</b>
                </div>

                <div class="card-body">
                    <form action="aksi_tambah_user.php" method="POST">

                        <h4>Jenis Pengguna</h4>

                        <div class="mb-3">
                            <label class="form-label">Daftar Sebagai:</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="siswa">Siswa</option>
                                <option value="guru">Guru</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <hr>

                        <div id="profil">
                            <h4>Data Profil User</h4>

                            <div class="mb-3" id="fieldNis">
                                <label class="form-label">NIS:</label>
                                <input type="text" class="form-control"
                                       name="nis" id="nis"
                                       placeholder="Nomor Induk Siswa">
                            </div>

                            <div class="mb-3" id="fieldNip" style="display:none;">
                                <label class="form-label">NIP:</label>
                                <input type="text" class="form-control"
                                       name="nip" id="nip"
                                       placeholder="Nomor Induk Guru">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap:</label>
                                <input type="text" class="form-control"
                                       name="nama" id="nama"
                                       placeholder="Masukkan nama lengkap" required>
                            </div>

                            <div class="mb-3" id="fieldKelas">
                                <label class="form-label">Kelas:</label>
                                <input type="text" class="form-control"
                                       name="kelas" id="kelas"
                                       placeholder="Contoh: XI-RPL-1">
                            </div>

                            <div class="mb-3" id="fieldJK">
                                <label class="form-label">Jenis Kelamin:</label><br>
                                <input type="radio" name="jenis_kelamin"
                                       value="Laki-laki" checked>
                                Laki-laki<br>

                                <input type="radio" name="jenis_kelamin"
                                       value="Perempuan">
                                Perempuan
                            </div>
                        </div>

                        <hr>

                        <h4>Data Kredensial Akun</h4>

                        <div class="mb-3">
                            <label class="form-label">Username:</label>
                            <input type="text" class="form-control"
                                   name="username"
                                   placeholder="Masukkan username" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password:</label>
                            <input type="password" class="form-control"
                                   name="password"
                                   placeholder="Masukkan password" required>
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
function aturForm() {
    const role = document.getElementById('role').value;

    const fieldNis = document.getElementById('fieldNis');
    const fieldNip = document.getElementById('fieldNip');
    const fieldKelas = document.getElementById('fieldKelas');
    const fieldJK = document.getElementById('fieldJK');

    const nis = document.getElementById('nis');
    const nip = document.getElementById('nip');
    const kelas = document.getElementById('kelas');

    fieldNis.style.display = 'none';
    fieldNip.style.display = 'none';
    fieldKelas.style.display = 'none';
    fieldJK.style.display = 'none';

    nis.required = false;
    nip.required = false;
    kelas.required = false;

    if (role === 'siswa') {
        fieldNis.style.display = 'block';
        fieldKelas.style.display = 'block';
        fieldJK.style.display = 'block';

        nis.required = true;
        kelas.required = true;

    } else if (role === 'guru') {
        fieldNip.style.display = 'block';
        fieldJK.style.display = 'block';

        nip.required = true;
    }
}

document.getElementById('role').addEventListener('change', aturForm);
aturForm();
</script>

<?php include "script.php"; ?>