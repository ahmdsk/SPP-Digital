<?php
require_once '../../../../Database.php';

$nisn = $_GET['nisn'];
if($nisn != ""){
    $data = $db->conn->prepare("DELETE FROM siswa WHERE nisn=$nisn");
    $data->execute();

    header("location: ../../data_siswa?pesan=berhasil");
} else {
    header("location: ../../data_siswa?pesan=tidak_ada_data");
}