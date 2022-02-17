<?php
session_start();
$title = 'Data Pembayaran';
require_once 'layout/header.php';
require_once '../Database.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-flex flex-row align-items-center justify-content-between py-2">
    <h1 class="h3 mb-2 text-gray-800"><?= $title ?></h1>
    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addModal">Tambah Data</button>
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
              <th>Tahun</th>
              <th>Nominal</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = $db->tampil("spp");
            $query->execute();
            while ($data = $query->fetch(PDO::FETCH_ASSOC)) :
            ?>
              <tr>
                <td><?= $data['tahun'] ?></td>
                <td>Rp. <?= number_format($data['nominal'], 0, '', '.') ?></td>
                <td>
                  <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal<?= $data['id_spp'] ?>"><i class="fas fa-edit"></i></button>
                  <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal<?= $data['id_spp'] ?>"><i class="fas fa-trash"></i></button>
                </td>
              </tr>
              <!-- modal edit -->
              <div class="modal fade" id="editModal<?= $data['id_spp'] ?>">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Edit <?= $title ?></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="data/pembayaran/edit.php" method="post">
                        <input type="hidden" name="id_spp" value="<?= $data['id_spp'] ?>">
                        <div class="row">
                          <div class="col-12">
                            <label for="tahun">Pilih Tahun</label>
                            <input type="number" name="tahun" id="tahun" class="form-control" value="<?= $data['tahun'] ?>">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <label for="nominal">Pilih Nominal</label>
                            <input type="number" name="nominal" id="nominal" class="form-control" value="<?= $data['nominal'] ?>">
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
              <div class="modal fade" id="deleteModal<?= $data['id_spp'] ?>">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Hapus <?= $title ?></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>Anda Yakin ingin menghapus data SPP tahun <?= $data['tahun'] ?> ?</p>
                      <div class="d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-sm btn-primary mr-1" data-dismiss="modal">Batal</button>
                        <a href="data/pembayaran/hapus.php?id_spp=<?= $data['id_spp'] ?>" class="btn btn-sm btn-danger">Yakin</a>
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

</div>
<!-- /.container-fluid -->

<!-- modal tambah -->
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
        <form action="data/pembayaran/tambah.php" method="post">
          <div class="row">
            <div class="col-12">
              <label for="tahun">Pilih Tahun</label>
              <input type="text" name="tahun" id="tahun" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="nominal">Pilih Nominal</label>
              <input type="text" name="nominal" id="nominal" class="form-control">
            </div>
          </div>

          <div class="row">
            <div class="col-12 d-flex justify-content-end">
              <input type="submit" class="btn btn-success mt-3" value="tambah">
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

<?php
require_once 'layout/footer.php';
?>