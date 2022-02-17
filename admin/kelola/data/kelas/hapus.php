<?php
require_once '../../../../Database.php';

$id_kls = $_GET['id'];
if($id_kls != ""){
    $data = $db->conn->prepare("DELETE FROM kelas WHERE id_kelas=$id_kls");
    $data->execute();

    header("location: ../../data_kelas?pesan=berhasil");
} else {
    header("location: ../../data_kelas?pesan=tidak_ada_data");
}