<?php
require_once '../../../../Database.php';

$nama    = $_POST['nama'];
$nisn    = $_POST['nisn'];
$nis     = $_POST['nis'];
$kelas   = $_POST['kelas'];
$no_telp = $_POST['no_telp'];
$alamat  = $_POST['alamat'];
$id_spp     = $_POST['spp'];

$data = $db->conn->prepare("UPDATE siswa SET nama='$nama', nisn='$nisn', nis='$nis', id_kelas=$kelas, id_spp=$id_spp, no_telp='$no_telp', alamat='$alamat' WHERE nisn='$nisn'");
$data->execute();
header("location: ../../data_siswa?pesan=berhasil");