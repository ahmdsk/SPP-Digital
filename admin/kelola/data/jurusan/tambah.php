<?php
require_once '../../../../Database.php';

$nama    = $_POST['nama_jurusan'];

$data = $db->conn->prepare("INSERT INTO jurusan (nama_jurusan) VALUES ('$nama')");
$data->execute();
header("location: ../../data_jurusan?pesan=berhasil");