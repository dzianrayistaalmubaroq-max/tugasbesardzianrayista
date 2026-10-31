<html lang="id">
<!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIPN</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
  
    body {
        background: linear-gradient(135deg, #eef4ff, #f8f9fa);
        min-height: 100vh;
    }

    .navbar {
        background: linear-gradient(90deg, #0d6efd, #6610f2) !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        padding: 12px 0;
    }

    .navbar-brand {
        color: white !important;
        font-size: 24px;
        letter-spacing: 1px;
    }

    .navbar .nav-link {
        color: white !important;
        margin-left: 5px;
        padding: 8px 14px !important;
        border-radius: 8px;
        transition: 0.3s;
    }

    .navbar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .dropdown-menu {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }

    .dropdown-item {
        padding: 10px 15px;
        transition: 0.2s;
    }

    .dropdown-item:hover {
        background-color: #eef4ff;
        color: #0d6efd;
    }

    .navbar-toggler {
        border-color: rgba(255, 255, 255, 0.5);
    }

    .navbar-toggler-icon {
        filter: brightness(0) invert(1);
    }
</style>

<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">SIPN</a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        Home
                    </a>
                </li>

                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle"
                href="#"
                id="formDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                Form
                </a>

                <ul class="dropdown-menu" aria-labelledby="formDropdown">
                <li><a class="dropdown-item" href="form2.php">Form 2</a></li>
                <li><a class="dropdown-item" href="form_edit_user.php">Form Edit User</a></li>
               <li><a class="dropdown-item" href="formall.php">Formall</a></li>
               </ul>
               </li>

                <li class="nav-item">
                    <a class="nav-link" href="daftar_guru.php">
                        Guru
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="daftar_siswa.php">
                        Siswa
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="daftar_mapel.php">
                        Mapel
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="daftar_mengajar.php">
                        Mengajar
                    </a>
                </li>

            </ul>

        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>