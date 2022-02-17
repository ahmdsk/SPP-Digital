<?php
session_start();
$title = 'Data Jurusan';
require_once 'layout/header.php';
require_once '../../Database.php';
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
              <th>Nama Jurusan</th>
              <th class="text-center">Opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = $db->tampil('jurusan');
            while ($data = $query->fetch(PDO::FETCH_ASSOC)) :
            ?>
              <tr>
                <td><?= $data['nama_jurusan'] ?></td>
                <td style="width: 150px; text-align: center">
                  <button class="btn btn-sm btn-success"><i class="fas fa-info-circle"></i></button>
                  <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal-<?= $data['id_jurusan'] ?>"><i class="fas fa-edit"></i></button>
                  <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal-<?= $data['id_jurusan'] ?>"><i class="fas fa-trash"></i></button>
                </td>
              </tr>

              <!-- Modal Edit Jurusan -->
              <div class="modal fade" id="editModal-<?= $data['id_jurusan'] ?>" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editModal">Edit <?= $title ?></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="data/jurusan/edit.php" method="post">
                      <input type="hidden" name="id"value="<?= $data['id_jurusan'] ?>">
                        <div class="row">
                          <div class="col-12">
                            <label for="nama">Nama Jurusan</label>
                            <input type="text" name="nama_jurusan" class="form-control" id="nama" value="<?= $data['nama_jurusan'] ?>" placeholder="Masukan Nama jurusan">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12 d-flex justify-content-end">
                            <input type="submit" class="btn btn-success mt-3">
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- modal delete -->
              <div class="modal fade" id="deleteModal-<?= $data['id_jurusan'] ?>">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Hapus <?= $title ?></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>Anda Yakin ingin menghapus jurusan <?= $data['nama_jurusan'] ?>.</p>
                      <div class="d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-sm btn-primary mr-1" data-dismiss="modal">Batal</button>
                        <a href="data/jurusan/hapus.php?id=<?= $data['id_jurusan'] ?>" class="btn btn-sm btn-danger">Yakin</a>
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

<!-- Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModal">Tambah <?= $title ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="data/jurusan/tambah.php" method="post">
          <div class="row">
            <div class="col-12">
              <label for="nama">Nama Jurusan</label>
              <input type="text" name="nama_jurusan" class="form-control" id="nama" placeholder="Masukan Nama jurusan">
            </div>
          </div>
          <div class="row">
            <div class="col-12 d-flex justify-content-end">
              <input type="submit" class="btn btn-success mt-3">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
require_once 'layout/footer.php';
?>