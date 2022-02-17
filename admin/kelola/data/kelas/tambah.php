<?php
require_once '../../../../Database.php';

$nama_kls    = $_POST['nm_kls'];
$jurusan    = $_POST['jurusan'];

$data = $db->conn->prepare("INSERT INTO kelas (nama_kelas, id_jurusan) VALUES ('$nama_kls', '$jurusan')");
$data->execute();
header("location: ../../data_kelas?pesan=berhasil");