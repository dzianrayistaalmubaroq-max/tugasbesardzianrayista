<?php
session_start();
require_once 'navbar.php';
require_once 'koneksi.php';

echo "<h1>Selamat Datang {$_SESSION['nama]}, Ia sebagai {$_SESSION['role']}</H1>";
?>
<br>
<a href=*logout.php">Logout</a>

<?php require_once 'footer.php' ?>