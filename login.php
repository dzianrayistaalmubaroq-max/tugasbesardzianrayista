<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $sql = "SELECT users.*,
            COALESCE(siswa.nama, guru.nama) AS nama,
            siswa.kelas
            FROM users
            LEFT JOIN siswa ON users.id = siswa.user_id
            LEFT JOIN guru ON users.id = guru.user_id
            WHERE users.username = ?";

    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $query = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($query);

        if ($data && password_verify($password, $data['password'])) {

            session_regenerate_id(true);

            // Samakan session dengan auth.php
            $_SESSION['id'] = $data['id'];
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama'] = $data['nama'] ?? $data['username'];
            $_SESSION['role'] = $data['role'];
            $_SESSION['kelas'] = $data['kelas'] ?? '';
            $_SESSION['login'] = true;

            header("Location: index.php");
            exit;

        } else {
            $error = "Username atau password salah!";
        }

        mysqli_stmt_close($stmt);

    } else {
        $error = "Terjadi kesalahan pada database. Periksa struktur tabel users, siswa, dan guru.";
    }
}
?><!doctype html>

<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"><title>Login SIPN</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet">

</head><body class="bg-light"><div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">        <div class="card shadow">
            <div class="card-header text-center bg-primary text-white">
                <h4>Login SIPN</h4>
            </div>

            <div class="card-body">

                <?php if ($error !== ''): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="login.php">

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text"
                               name="username"
                               class="form-control"
                               placeholder="Masukkan username"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Masukkan password"
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Login
                    </button>

                </form>

                <div class="text-center mt-3">
                    Belum punya akun?
                    <a href="registrasi.php"
                       class="text-primary text-decoration-none">
                        Registrasi
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

</div></body>
</html>