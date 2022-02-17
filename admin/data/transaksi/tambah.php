<?php

    require_once '../../../Database.php';
    session_start();

    $id_petugas = $_SESSION['id_petugas'];
    $nisn       = explode('-', $_POST['nisn']);
    $tgl_bayar  = $_POST['tgl_bayar'];
    $bulan      = $_POST['bulan'];
    $tahun      = $_POST['tahun'];
    $id_spp     = explode('-', $_POST['nisn']);
    $jml_bayar  = $_POST['jml_bayar'];


    $add_pay = $db->conn->prepare("INSERT INTO pembayaran 
                                    (id_petugas, nisn, tgl_bayar, bulan_dibayar, tahun_dibayar, id_spp, jumlah_bayar, status)
                                    VALUES ('$id_petugas', '$nisn[0]', '$tgl_bayar', '$bulan', '$tahun', '$id_spp[1]', '$jml_bayar', 'lunas')");
    $add_pay->execute();
    header("location: ../../transaksi?pesan=berhasil");