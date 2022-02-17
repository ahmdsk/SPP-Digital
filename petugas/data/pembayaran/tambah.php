<?php
include '../../../Database.php';

$bayar      = $_POST['bayar'];
$kelas      = $_POST['kelas'];
$thn_ajaran = $_POST['thn_ajaran'];
$jml_bayar  = $_POST['jml_bayar'];

if($bayar && $kelas && $thn_ajaran && $jml_bayar != ""){
    $data = $db->conn->prepare("INSERT INTO data_bayar (pembayaran, kelas, tahun_ajaran, jumlah_bayar)
                            VALUES ('$bayar', '$kelas', '$thn_ajaran', '$jml_bayar')");
    $data->execute();
    header("location: ../../pembayaran.php?pesan=berhasil");
}else {
    header("location: ../../pembayaran.php?pesan=gagal");
}