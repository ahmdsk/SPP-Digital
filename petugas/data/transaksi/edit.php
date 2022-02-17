<?php

    require_once '../../../Database.php';

    $id_bayar   = $_POST['id_pembayaran'];
    $nisn       = explode('-', $_POST['nisn']);
    $tgl_bayar  = $_POST['tgl_bayar'];
    $bulan      = $_POST['bulan'];
    $tahun      = $_POST['tahun'];
    $id_spp     = explode('-', $_POST['nisn']);
    $jml_bayar  = $_POST['nominal'];

    $edit_pay = $db->conn->prepare("UPDATE pembayaran SET nisn='$nisn[0]', tgl_bayar='$tgl_bayar', bulan_dibayar='$bulan', tahun_dibayar='$tahun', jumlah_bayar='$jml_bayar'  WHERE id_pembayaran=$id_bayar");
    $edit_pay->execute();
    header("location: ../../transaksi?pesan=berhasil");

?>