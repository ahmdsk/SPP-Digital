<?php
require_once '../../../../Database.php';

$nama_kls = $_POST['nm_kls'];
$jurusan  = $_POST['jurusan'];
$id       = $_POST['id_kls'];

$data = $db->conn->prepare("UPDATE kelas SET nama_kelas='$nama_kls', id_jurusan='$jurusan' WHERE id_kelas='$id'");
$data->execute();
header("location: ../../data_kelas?pesan=berhasil");