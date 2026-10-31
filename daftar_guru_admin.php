<?php
include 'auth_admin.php';
include 'navbar_admin.php';

$data = mysqli_query($koneksi, "SELECT guru.*, users.username
    FROM guru
    LEFT JOIN users ON users.id = guru.user_id
    ORDER BY guru.id");
?>

<div class="container mt-4">
    <h2 class="text-center mb-3">Daftar Guru</h2>

    <?php if (isset($_GET['pesan'])) { ?>
        <div class="alert alert-info">
            <?php
            if ($_GET['pesan'] == 'tambah') echo "Data guru berhasil ditambahkan";
            elseif ($_GET['pesan'] == 'edit') echo "Data guru berhasil diubah";
            elseif ($_GET['pesan'] == 'hapus') echo "Data guru berhasil dihapus";
            elseif ($_GET['pesan'] == 'kosong') echo "NIP, nama, dan jenis kelamin harus diisi";
            elseif ($_GET['pesan'] == 'kembar') echo "NIP sudah terdaftar";
            elseif ($_GET['pesan'] == 'akun') echo "Akun yang dipilih tidak valid atau sudah dipakai guru lain";
            else echo "Terjadi kesalahan, data mungkin masih dipakai";
            ?>
        </div>
    <?php } ?>

    <a href="form_guru_admin.php" class="btn btn-primary btn-sm mb-3">Tambah Guru</a>

    <table id="tabel" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Akun Login</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($d = mysqli_fetch_assoc($data)) {
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($d['nip']); ?></td>
                    <td><?php echo htmlspecialchars($d['nama']); ?></td>
                    <td><?php if ($d['jenis_kelamin'] == 'L') echo "Laki-laki"; else echo "Perempuan"; ?></td>
                    <td><?php if ($d['username']) echo htmlspecialchars($d['username']); else echo "-"; ?></td>
                    <td>
                        <a href="form_guru_admin.php?id=<?php echo $d['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form action="aksi_guru_admin.php" method="post" style="display:inline"
                            onsubmit="return confirm('Yakin hapus guru ini?')">
                            <input type="hidden" name="aksi" value="hapus">
                            <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer_admin.php'; ?>
<script>
    $(document).ready(function () {
        $('#tabel').DataTable({
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            language: {
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                search: "Cari:",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data",
                infoFiltered: "",
                zeroRecords: "Data tidak ditemukan",
                paginate: { previous: "Sebelumnya", next: "Selanjutnya" }
            }
        });
    });
                  </script>