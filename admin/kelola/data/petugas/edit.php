<?php
require_once '../../../../Database.php';

$id     = $_POST['id'];
$nama   = $_POST['nama'];
$email  = $_POST['email'];
$level  = $_POST['level'];

$data = $db->conn->prepare("UPDATE petugas SET nama_petugas='$nama', email='$email', level='$level' WHERE id_petugas='$id'");
$data->execute();
header("location: ../../data_petugas?pesan=berhasil");