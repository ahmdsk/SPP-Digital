<?php
require_once '../../../Database.php';

$id_spp = $_GET['id_spp'];
if($id_spp != ""){
    $data = $db->conn->prepare("DELETE FROM data_bayar WHERE id_spp=$id_spp");
    $data->execute();

    header("location: ../../pembayaran.php?pesan=berhasil");
} else {
    header("location: ../../pembayaran.php?pesan=tidak_ada_data");
}