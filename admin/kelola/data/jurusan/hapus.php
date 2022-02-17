<?php
require_once '../../../../Database.php';

$id_jurusan = $_GET['id'];
if($id_jurusan != ""){
    $data = $db->conn->prepare("DELETE FROM jurusan WHERE id_jurusan=$id_jurusan");
    $data->execute();

    header("location: ../../data_jurusan?pesan=berhasil");
} else {
    header("location: ../../data_jurusan?pesan=tidak_ada_data");
}