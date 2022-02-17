<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Transaksi Pembayaran | Aplikasi SPP</title>

    <!-- Custom fonts for this template-->
    <link href="../../themes/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- css select picker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">


    <!-- Custom styles for this template-->
    <link href="../../themes/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../themes/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://sb-admin-pro.startbootstrap.com/css/styles.css"> -->

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Transaksi Pembayaran</h6>
                            <div class="dropdown no-arrow">
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
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php

                                require_once '../../plugins/dompdf/autoload.inc.php';

                                use Dompdf\Dompdf;

                                $dompdf = new Dompdf();

                                $html = "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                                        <thead>
                                            <tr>
                                                <th>ID Pembayaran</th>
                                                <th>Petugas(ID)</th>
                                                <th>NISN</th>
                                                <th>Tgl Bayar</th>
                                                <th>Bulan dibayar</th>
                                                <th>Tahun dibayar</th>
                                                <th>Jumlah bayar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class='text-center'>
                                                <td>SPP-3</td>
                                                <td>Super Admin(3)</td>
                                                <td>004197908</td>
                                                <td>2022-02-07</td>
                                                <td>Januari</td>
                                                <td>2021</td>
                                                <td>Rp 100,000</td>
                                            </tr>
                                        </tbody>
                                    </table>";

                                $dompdf->loadHtml($html);

                                // (Optional) Setup the paper size and orientation
                                $dompdf->setPaper('A4', 'potrait');

                                // Render the HTML as PDF
                                $dompdf->render();

                                // Output the generated PDF to Browser
                                $dompdf->stream('pembayaran.pdf', array('Attachment' => false));
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


    <!-- Bootstrap core JavaScript-->
    <script src="../../themes/vendor/jquery/jquery.min.js"></script>
    <script src="../../themes/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../themes/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../themes/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../themes/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../themes/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../themes/js/demo/datatables-demo.js"></script>

</body>

</html>