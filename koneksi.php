<?php

$host = "127.0.0.1";
$username = "root";
$pass = "root";
$database = "dzianrayista_sipn";

$koneksi = mysqli_connect($host, $username, $pass, $database, 3306);

if (!$koneksi) {
    die("koneksi kedatabase gagal: " . mysqli_connect_error());
}

?>