<?php
require_once '../../../../Database.php';

$id           = $_POST['id'];
$nama_jurusan = $_POST['nama_jurusan'];

$data = $db->conn->prepare("UPDATE jurusan SET nama_jurusan='$nama_jurusan' WHERE id_jurusan='$id'");
$data->execute();
header("location: ../../data_jurusan?pesan=berhasil");