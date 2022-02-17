<?php

require_once '../Database.php';
require_once __DIR__ . '/../vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

// data from db
$id = $_GET['id'];

$data = $db->conn->prepare("SELECT * FROM pembayaran
                        INNER JOIN siswa ON pembayaran.nisn=siswa.nisn
                        INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas
                        WHERE pembayaran.id_pembayaran='$id'");
$data->execute();
$siswa = $data->fetch(PDO::FETCH_ASSOC);

// set title name of file
$title = $mpdf->SetTitle('Bukti Pembayaran '.$siswa['nama'].' - '.$siswa['tgl_bayar']);

if($siswa == false){
    header("location: ../404");
}

$mpdf->WriteHTML('
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
  .container {
    padding-top: 50px;
    margin: 0 50px 0 50px;
  }
  
  .head {
    width: 100%;
    text-align: center;
    line-height: 10px;
  }
  
  hr {
    height: 2px;
    background-color: black;
  }
  
  table td.row {
    font-weight: bold;
    padding-right: 100px;
  }
  
  .footer {
    text-align: center;
  }
  </style>
</head>
<body>
  <div class="container">
    <div class="head">
       <h1>Bukti Pembayaran SPP</h1>
       <h3>Siswa/i SMKN 8 Jakarta Tengah</h3>
       <p>https://smk.co.id</p>
   </div>
  
   <hr>
    
   <table>
    <tr>
        <td class="row">NISN</td>
        <td>: '.$siswa['nisn'].'</td>
    </tr>
     <tr>
       <td class="row">Nama Siswa</td>
       <td>: '.$siswa['nama'].'</td>
     </tr>
     <tr>
       <td class="row">Tanggal Bayar</td>
       <td>: '.$siswa['tgl_bayar'].'</td>
     </tr>
     <tr>
       <td class="row">Jumlah Bayar</td>
       <td>: Rp. '.number_format($siswa['jumlah_bayar'], '0').'</td>
     </tr>
     <tr>
       <td class="row">Pembayaran Bulan</td>
       <td>: '.$siswa['bulan_dibayar'].'</td>
     </tr>
     <tr>
       <td class="row">Tahun</td>
       <td>: '.$siswa['tahun_dibayar'].'</td>
     </tr>
     <tr>
       <td class="row">Status</td>
       <td>: '.$siswa['status'].'</td>
     </tr>
     <tr>
       <td class="row">Nama Petugas</td>
       <td>: '.$siswa['nama_petugas'].'</td>
     </tr>
     
   </table>
    
   <hr>
    
   <p>Berkas Cetak Ini Merupakan Bukti Resmi status pembayaran biaya spp siswa/i pada bulan '.$siswa['bulan_dibayar'].' tahun '.$siswa['tahun_dibayar'].' telah <b>lunas</b></p>
    
    <p class="footer">
      &copy; SPP Digital ' . date('Y') . '
    </p>
   
  </div>  
</body>
</html>
');
$mpdf->Output($title);
