<?php
session_start();
require_once 'Alerts.php';
if (!empty($_SESSION['email'])) {
    header("location: admin/");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login | Aplikasi SPP</title>

    <!-- Custom fonts for this template-->
    <link href="themes/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="themes/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-dark">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-4 col-md-6 col-sm-12">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="themes/img/logo-sma.png" alt="Logo" style="width: 200px">
                                        <h1 class="h4 text-gray-900 mb-4">Aplikasi <b>SPP</b></h1>
                                    </div>
                                    <!-- <?= $alert->alert('error', 'danger') ?> -->
                                    <?php
                                    if (isset($_GET['pesan'])) {
                                        if ($_GET['pesan'] == 'gagal') {
                                            echo $alert->alert('gagal login! silahkan login kembali', 'danger');
                                        } elseif ($_GET['pesan'] == 'tidak_ditemukan') {
                                            echo $alert->alert('email atau password salah!', 'primary');
                                        } elseif ($_GET['pesan'] == 'kosong') {
                                            echo $alert->alert('isi kolom email dan password!', 'warning');
                                        } elseif ($_GET['pesan'] == 'belum_login') {
                                            echo $alert->alert('Silahkan login terlebih dahulu!', 'warning');
                                        } elseif ($_GET['pesan'] = 'logout') {
                                            echo $alert->alert('Berhasil Logout', 'success');
                                        }
                                    }
                                    ?>
                                    <hr>
                                    <form action="cek_login.php" method="post" class="user">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user" placeholder="Masukan Email anda...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-dark btn-user btn-block">
                                            Login
                                        </button>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="themes/vendor/jquery/jquery.min.js"></script>
    <script src="themes/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="themes/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>