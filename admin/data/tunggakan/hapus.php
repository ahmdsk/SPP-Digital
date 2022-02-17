<?php
require_once '../../../Database.php';

$id_bayar = $_GET['id_bayar'];
if($id_bayar != ""){
    $data = $db->conn->prepare("DELETE FROM pembayaran WHERE id_pembayaran=$id_bayar");
    $data->execute();

    header("location: ../../tunggakan?pesan=berhasil");
} else {
    header("location: ../../tunggakan?pesan=tidak_ada_data");
}