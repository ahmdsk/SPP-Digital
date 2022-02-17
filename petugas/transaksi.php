<?php
session_start();
$title = 'Transaksi Pembayaran';
require_once 'layout/header.php';
require_once '../Database.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="d-flex flex-row align-items-center justify-content-between py-2">
        <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
        <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addModal">Entri Pembayaran</button>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Pembayaran</th>
                            <th>Petugas(ID)</th>
                            <th>NISN</th>
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
                                                    WHERE pembayaran.status='lunas'");
                        $query->execute();
                        while ($data = $query->fetch(PDO::FETCH_ASSOC)) :
                        ?>
                            <tr class="text-center">
                                <td>SPP-<?= $data['id_pembayaran'] ?></td>
                                <td><?= $data['nama_petugas'] ?>(<?= $data['id_petugas'] ?>)</td>
                                <td><?= $data['nisn'] ?></td>
                                <td><?= $data['tgl_bayar'] ?></td>
                                <td><?= $data['bulan_dibayar'] ?></td>
                                <td><?= $data['tahun_dibayar'] ?></td>
                                <td>Rp <?= number_format($data['jumlah_bayar'], 0) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal<?= $data['id_pembayaran'] ?>"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal<?= $data['id_pembayaran'] ?>"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>

                            <!-- modal edit -->
                            <div class="modal fade" id="editModal<?= $data['id_pembayaran'] ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit <?= $title ?></h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="data/transaksi/edit.php" method="post">
                                                <input type="hidden" name="id_pembayaran" value="<?= $data['id_pembayaran'] ?>">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="nisn">NISN</label>
                                                        <select name="nisn" id="nisn" class="form-control">
                                                            <?php
                                                            $dt_siswa = $db->tampil('siswa');
                                                            while ($siswa = $dt_siswa->fetch(PDO::FETCH_ASSOC)) {
                                                                if ($siswa['nisn'] == $data['nisn']) {
                                                                    echo '<option value="' . $data['nisn'] . '-' . $siswa['id_spp'] . '" selected="selected">' . $data['nisn'] . ' - ' . $data['nama'] . '</option>';
                                                                } else {
                                                                    echo '<option value="' . $siswa['nisn'] . '-' . $siswa['id_spp'] . '">' . $siswa['nisn'] . ' - ' . $siswa['nama'] . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="tgl_bayar">Tanggal Bayar</label>
                                                        <input type="date" name="tgl_bayar" id="tgl_bayar" class="form-control" value="<?= $data['tgl_bayar'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="bulan">Bulan dibayar</label>
                                                        <select name="bulan" id="bulan" class="form-control">
                                                            <?php
                                                            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                                            foreach ($bulan as $bln) {
                                                                if ($bln == $data['bulan_dibayar']) {
                                                                    echo '<option value="' . $data['bulan_dibayar'] . '" selected="selected">' . $data['bulan_dibayar'] . '</option>';
                                                                } else {
                                                                    echo '<option value="' . $bln . '">' . $bln . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="tahun">Pilih Tahun</label>
                                                        <input type="number" name="tahun" id="tahun" class="form-control" value="<?= $data['tahun_dibayar'] ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="nominal">Pilih Nominal</label>
                                                        <input type="number" name="nominal" id="nominal" class="form-control" value="<?= $data['jumlah_bayar'] ?>">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-end">
                                                        <input type="submit" class="btn btn-success mt-3" value="Edit">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->

                            <!-- modal delete -->
                            <div class="modal fade" id="deleteModal<?= $data['id_pembayaran'] ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Hapus <?= $title ?></h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Anda Yakin ingin menghapus <?= $title ?> <?= 'SPP-' . $data['id_pembayaran'] ?> ?</p>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <button type="button" class="btn btn-sm btn-primary mr-1" data-dismiss="modal">Batal</button>
                                                <a href="data/transaksi/hapus.php?id_bayar=<?= $data['id_pembayaran'] ?>" class="btn btn-sm btn-danger">Yakin</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- modal add -->
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah <?= $title ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="data/transaksi/tambah.php" method="post">
                        <div class="row">
                            <div class="col-12">
                                <label for="nisn">NISN</label>
                                <select name="nisn" id="nisn" class="form-control selectpicker" data-live-search="true">
                                    <?php
                                    $dt_siswa = $db->tampil('siswa');
                                    while ($siswa = $dt_siswa->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $siswa['nisn'] . '-' . $siswa['id_spp'] . '">' . $siswa['nisn'] . ' - ' . $siswa['nama'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="tgl_bayar">Tanggal Bayar</label>
                                <input type="date" name="tgl_bayar" id="tgl_bayar" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="bulan">Bulan dibayar</label>
                                <select name="bulan" id="bulan" class="form-control selectpicker" data-live-search="true">
                                    <?php
                                    $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                    foreach ($bulan as $bln) {
                                        echo '<option value="' . $bln . '" data-tokens="' . $bln . '">' . $bln . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="tahun">Tahun dibayar</label>
                                <input type="number" name="tahun" id="tahun" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="jml_bayar">Jumlah bayar</label>
                                <input type="number" name="jml_bayar" id="jml_bayar" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <input type="submit" class="btn btn-success mt-3" value="Proses">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

</div>
<!-- /.container-fluid -->

<?php
require_once 'layout/footer.php';
?>
<!-- <script>
    $('#nisn').on('change', function() {
        console.log($(this).find(':selected').data('spp'));
    });
</script> -->