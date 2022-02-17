<?php
require_once '../../../../Database.php';

$nama    = htmlspecialchars($_POST['nama']);
$email   = $_POST['email'];
$pass    = password_hash($_POST['pass'], PASSWORD_DEFAULT);
$level   = $_POST['level'];

$data = $db->conn->prepare("INSERT INTO petugas (email, password, nama_petugas, level) VALUES ('$email', '$pass', '$nama', '$level')");
$data->execute();
header("location: ../../data_petugas?pesan=berhasil");