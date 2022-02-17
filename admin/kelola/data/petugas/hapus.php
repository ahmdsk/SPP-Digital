<?php
require_once '../../../../Database.php';

$id_petugas = $_GET['id'];
if($id_petugas != ""){
    $data = $db->conn->prepare("DELETE FROM petugas WHERE id_petugas=$id_petugas");
    $data->execute();

    header("location: ../../data_petugas?pesan=berhasil");
} else {
    header("location: ../../data_petugas?pesan=tidak_ada_data");
}