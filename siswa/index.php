<?php

session_start();
$title = "Dashboard";
if ($_SESSION['nisn'] == null) {
    header("location: ../?pesan=belum_login");
}
require_once 'layout/header.php';
require_once '../Database.php';
require_once '../Alerts.php';

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Bayar (Keseluruhan)</div>
                            <?php
                            $nisn = $_SESSION['nisn'];
                            $spp = $db->conn->prepare("SELECT SUM(jumlah_bayar) AS nominal FROM pembayaran WHERE nisn='$nisn' AND status='lunas'");
                            $spp->execute();
                            $dt_spp = $spp->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= number_format($dt_spp['nominal'], 0, '', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pembayaran Lunas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $db->getStatus("lunas") ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tunggakan Pembayaran</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $db->getStatus("belum lunas") ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Status</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= 'Siswa' ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Row -->

    <!-- DataTables Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">History Pembayaran</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Opsi:</div>
                    <a class="dropdown-item" href="#">Cetak Data</a>
                    <a class="dropdown-item" href="#">Import Data</a>
                    <a class="dropdown-item" href="#">Export Data</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Kembalikan Data</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Pembayaran</th>
                            <th>Tgl Pembayaran</th>
                            <th>Bulan Bayar</th>
                            <th>Tahun Bayar</th>
                            <th>Jumlah bayar</th>
                            <th>Petugas</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $nisn = $_SESSION['nisn'];
                        $query = $db->conn->prepare("SELECT * FROM pembayaran
                                                    INNER JOIN siswa ON pembayaran.nisn=siswa.nisn
                                                    INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas
                                                    WHERE siswa.nisn='$nisn'");
                        $query->execute();
                        while ($data = $query->fetch(PDO::FETCH_ASSOC)) :
                        ?>
                            <tr class="text-center">
                                <td><?= $no++ ?></td>
                                <td>P-<?= $data['id_pembayaran'] ?></td>
                                <td><?= $data['tgl_bayar'] ?></td>
                                <td><?= $data['bulan_dibayar'] ?></td>
                                <td><?= $data['tahun_dibayar'] ?></td>
                                <td>Rp <?= number_format($data['jumlah_bayar'], 0) ?></td>
                                <td><?= $data['nama_petugas'] ?></td>
                                <td>
                                    <?php
                                    if ($data['status'] == "lunas") {
                                        echo '<span class="badge badge-success p-1">Lunas</span>';
                                    } else {
                                        echo '<span class="badge badge-warning">Belum Lunas</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($data['status'] == "lunas") {
                                        echo '<a class="btn btn-sm btn-primary" href="print.php?id='.$data['id_pembayaran'].'"><i class="fas fa-print"></i> Print</a>';
                                    } else {
                                        echo '<button class="btn btn-sm btn-primary btn-bayar" data-toggle="modal" data-target="#payModal"><i class="fas fa-fw fa-money-bill-wave"></i> Bayar</button>';
                                    }
                                    ?>
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

<!-- modal pembayaran -->
<div class="modal fade" id="payModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Bayar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-primary">
                            Silahkan Lakukan Pembayaran Ke Tata Usaha Dan Temui <strong>Petugas Pembayaran</strong>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php
require_once 'layout/footer.php';
?>


<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-8cxjOyRbN9T_T4bQ"></script>
<script>
    $('.btn-bayar').on('click', function() {
        let id = $(this).data('target').split("-");
        // console.log(id[1]);
    });

    $('#bayar').on('change', function() {
        var value = $(this).val();
        if (value == "online") {
            $('#bayar').on('click', function() {
                snap.pay('<?= $snapToken ?>', {
                    // Optional
                    onSuccess: function(result) {
                        /* You may add your own js here, this is just example */
                        console.log(JSON.stringify(result, null, 2));
                    },
                    // Optional
                    onPending: function(result) {
                        /* You may add your own js here, this is just example */
                        console.log(JSON.stringify(result, null, 2));
                    },
                    // Optional
                    onError: function(result) {
                        /* You may add your own js here, this is just example */
                        console.log(JSON.stringify(result, null, 2));
                    }
                });
            })
        }
    });
</script>