<?php
require_once '../../../Database.php';

$id_spp   = $_POST['id_spp'];
$tahun    = $_POST['tahun'];
$nominal  = $_POST['nominal'];

$data = $db->conn->prepare("UPDATE spp SET tahun=$tahun, nominal=$nominal WHERE id_spp=$id_spp");
$data->execute();
header("location: ../../pembayaran.php?pesan=berhasil");