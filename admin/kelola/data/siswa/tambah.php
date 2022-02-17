<?php
require_once '../../../../Database.php';

$nama    = $_POST['nama'];
$nisn    = $_POST['nisn'];
$nis     = $_POST['nis'];
$kelas   = $_POST['kelas'];
$no_telp = $_POST['no_telp'];
$alamat  = $_POST['alamat'];
$id_spp  = $_POST['spp'];
$pass    = password_hash('siswa', PASSWORD_DEFAULT);

$data = $db->conn->prepare("INSERT INTO siswa (nama, nisn, nis, id_kelas, password, no_telp, alamat, id_spp)
                            VALUES ('$nama', '$nisn', '$nis', $kelas, '$pass', '$no_telp', '$alamat', $id_spp)");
$data->execute();
header("location: ../../data_siswa.php?pesan=berhasil");