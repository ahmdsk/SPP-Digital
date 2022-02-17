<?php

use Dompdf\Dompdf;

session_start();
$title = 'History Pembayaran';
require_once 'layout/header.php';
require_once '../Database.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-flex flex-row align-items-center justify-content-between py-2">
    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
      <!-- <div class="dropdown no-arrow">
        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
          <div class="dropdown-header">Opsi:</div>
          <a class="dropdown-item" href="cetak/cetak_transaksi.php">Cetak Data</a>
          <a class="dropdown-item" href="#">Import Data</a>
          <a class="dropdown-item" href="#">Export Data</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Kembalikan Data</a>
        </div>
      </div> -->
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID Pembayaran</th>
              <th>Petugas</th>
              <th>Nama Siswa</th>
              <th>NISN</th>
              <th>Kelas</th>
              <th>Tgl Bayar</th>
              <th>Bulan dibayar</th>
              <th>Tahun dibayar</th>
              <th>Jumlah bayar</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = $db->conn->prepare("SELECT * FROM pembayaran
                                                    INNER JOIN siswa ON pembayaran.nisn=siswa.nisn
                                                    INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas
                                                    INNER JOIN spp ON pembayaran.id_spp=spp.id_spp
                                                    INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas
                                                  WHERE pembayaran.status='lunas'");
            $query->execute();
            while ($data = $query->fetch(PDO::FETCH_ASSOC)) :
            ?>
              <tr class="text-center">
                <td>SPP-<?= $data['id_pembayaran'] ?></td>
                <td><?= $data['nama_petugas'] ?></td>
                <td><?= $data['nama'] ?></td>
                <td><?= $data['nisn'] ?></td>
                <td><?= $data['nama_kelas'] ?></td>
                <td><?= $data['tgl_bayar'] ?></td>
                <td><?= $data['bulan_dibayar'] ?></td>
                <td><?= $data['tahun_dibayar'] ?></td>
                <td>Rp <?= number_format($data['jumlah_bayar'], 0) ?></td>
                <td>
                  <a class="btn btn-sm btn-success" href="print?id=<?= $data['id_pembayaran'] ?>"><i class="fas fa-print"></i></a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php
require_once 'layout/footer.php';
?>