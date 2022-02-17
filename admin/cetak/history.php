    <?php
    require_once "../../Database.php";
    require_once '../../plugins/dompdf/autoload.inc.php';

    use Dompdf\Dompdf;
    use Dompdf\Options;

    $dompdf = new Dompdf();
    $options = new Options();

    $options->set('defaultFont', 'Courier');
    $options->set('isRemoteEnabled', TRUE);
    $options->set('debugKeepTemp', TRUE);
    $options->set('isHtml5ParserEnabled', FALSE);

    $id = $_GET["id"];
    $query = $db->conn->prepare("SELECT * FROM pembayaran
                                    INNER JOIN siswa ON pembayaran.nisn=siswa.nisn
                                    INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas
                                    INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas
                                WHERE id_pembayaran='$id'");
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);

    $dompdf->loadHtml('
    <!doctype html>
    <html lang="en">
    
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    
        <title>Cetak Pembayaran</title>
    </head>
    
    <body>
    
            <div class="container">
                <div class="d-flex align-items-center">
                    <img src="../../img/logo-sma.png" alt="" style="width: 200px">
                    <div class="text-center">
                        <h2>KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN</h2>
                        <p>SMKN 8 BANDAR LAMPUNG</p>
                        <p>PEMBAYARAN SPP DIGITAL</p>
                    </div>
                </div>
                <hr class="bg-dark">
                <h2 class="text-center">
                    BUKTI PEMBAYARAN SPP
                </h2>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th scope="row">Nama</th>
                                    <td>' . $data["nama"] . '</td>
                                </tr>
                                <tr>
                                    <th scope="row">NISN</th>
                                    <td>' . $data["nisn"] . '</td>
                                </tr>
                                <tr>
                                    <th scope="row">Kelas</th>
                                    <td>' . $data["nama_kelas"] . '</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tanggal Bayar</th>
                                    <td>' . $data["tgl_bayar"] . '</td>
                                </tr>
                                <tr>
                                    <th scope="row">Bulan Dibayar</th>
                                    <td>' . $data["bulan_dibayar"] . '</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tahun Dibayar</th>
                                    <td>' . $data["tahun_dibayar"] . '</td>
                                </tr>
                                <tr>
                                    <th scope="row">Jumlah Bayar</th>
                                    <td>' . $data["jumlah_bayar"] . '</td>
                                </tr>
                                <tr>
                                    <th scope="row">Petugas</th>
                                    <td>' . $data["nama_petugas"] . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    </body>
    
    </html>
    ');

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'potrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    $dompdf->stream('history.pdf', array('Attachment' => false));

    ?>