<?php
session_start();
if ($_SESSION['email'] == null) {
  header("location: ../index.php?pesan=belum_login");
}
$title = 'Data Siswa';
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
              <th>Nama</th>
              <th>NISN</th>
              <th>NIS</th>
              <th>Kelas</th>
              <th>Jurusan</th>
              <th>Alamat</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = $db->conn->prepare("SELECT * FROM siswa 
                                        INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas
                                        INNER JOIN jurusan ON kelas.id_jurusan=jurusan.id_jurusan
                                        INNER JOIN spp ON siswa.id_spp=spp.id_spp");
            $query->execute();
            while ($data = $query->fetch(PDO::FETCH_ASSOC)) :
            ?>
              <tr>
                <td><?= $data['nama'] ?></td>
                <td><?= $data['nisn'] ?></td>
                <td><?= $data['nis'] ?></td>
                <td><?= $data['nama_kelas'] ?></td>
                <td><?= $data['nama_jurusan'] ?></td>
                <td><?= $data['alamat'] ?></td>
                <td>
                  <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addPayModal<?= $data['nisn'] ?>"><i class="fas fa-money-check-alt"></i></button>
                  <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal<?= $data['nisn'] ?>"><i class="fas fa-edit"></i></button>
                  <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal<?= $data['nisn'] ?>"><i class="fas fa-trash"></i></button>
                </td>
              </tr>

              <!-- modal Edit -->
              <div class="modal fade" id="editModal<?= $data['nisn'] ?>">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Edit <?= $title ?></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="data/siswa/edit.php" method="post">
                        <div class="row">
                          <div class="col-12">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama siswa" value="<?= $data['nama'] ?>">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6">
                            <label for="nisn">NISN</label>
                            <input type="number" name="nisn" class="form-control" id="nisn" placeholder="Masukan NISN" value="<?= $data['nisn'] ?>">
                          </div>
                          <div class="col-6">
                            <label for="nisn">NIS</label>
                            <input type="number" name="nis" class="form-control" id="nis" placeholder="Masukan NIS" value="<?= $data['nis'] ?>">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <label for="spp">Tahun SPP</label>
                            <select class="custom-select" name="spp" id="spp">
                              <option disabled selected>=== Pilih Tahun ===</option>
                              <?php
                                $select_spp = $data['tahun'];
                                $qjr = $db->tampil("spp");
                                while ($spp = $qjr->fetch(PDO::FETCH_ASSOC)) :
                                  if ($select_spp === $spp['tahun']) {
                                    echo '<option value="' . $data['id_spp'] . '" selected>' . $select_spp . '</option>';
                                  } else {
                                    echo '<option value="' . $spp['id_spp'] . '">' . $spp['tahun'] . '</option>';
                                  }
                                endwhile;
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <label for="jurusan">Jurusan</label>
                            <select class="custom-select" name="jurusan" id="jurusan" disabled>
                              <?= '<option value="' . $data['id_jurusan'] . '" selected>' . $data['nama_jurusan'] . '</option>'; ?>
                            </select>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6">
                            <label for="kelas">Kelas</label>
                            <select class="custom-select" name="kelas" id="kelas">
                              <option disabled selected>=== Pilih Kelas ===</option>
                              <?php
                              $selected = $data['nama_kelas'];
                              $data_kelas = $db->conn->prepare("SELECT * FROM kelas");
                              $data_kelas->execute();
                              while ($kelas = $data_kelas->fetch(PDO::FETCH_ASSOC)) :
                                if ($selected === $kelas['nama_kelas']) {
                                  echo '<option value="' . $data['id_kelas'] . '" selected>' . $selected . '</option>';
                                } else {
                                  echo '<option value="' . $kelas['id_kelas'] . '">' . $kelas['nama_kelas'] . '</option>';
                                }
                              endwhile;
                              ?>
                            </select>
                          </div>
                          <div class="col-6">
                            <label for="no">No telp</label>
                            <input type="number" name="no_telp" class="form-control" id="no" placeholder="No Telepon" value="<?= $data['no_telp'] ?>">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" class="form-control" id="alamat" cols="20" rows="5" placeholder="Alamat Siswa"><?= $data['alamat'] ?></textarea>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-success mt-3" name="simpan">Simpan</button>
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
              <div class="modal fade" id="deleteModal<?= $data['nisn'] ?>">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Hapus <?= $title ?></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>Anda Yakin ingin menghapus data <?= $data['nama'] ?>.</p>
                      <div class="d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-sm btn-primary mr-1" data-dismiss="modal">Batal</button>
                        <a href="data/siswa/hapus.php?nisn=<?= $data['nisn'] ?>" class="btn btn-sm btn-danger">Yakin</a>
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
        <form action="data/siswa/tambah.php" method="post">
          <div class="row">
            <div class="col-12">
              <label for="nama">Nama</label>
              <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukan Nama siswa">
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <label for="nisn">NISN</label>
              <input type="number" name="nisn" class="form-control" id="nisn" placeholder="Masukan NISN">
            </div>
            <div class="col-6">
              <label for="nis">NIS</label>
              <input type="number" name="nis" class="form-control" id="nis" placeholder="Masukan NIS">
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="spp">Tahun SPP</label>
              <select class="custom-select" name="spp" id="spp">
                <option disabled selected>=== Pilih Tahun ===</option>
                <?php
                $qjr = $db->tampil("spp");
                while ($dt = $qjr->fetch(PDO::FETCH_ASSOC)) :
                ?>
                  <option value="<?= $dt['id_spp'] ?>"><?= $dt['tahun'] ?></option>
                <?php
                endwhile;
                ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <label for="kelas">Kelas</label>
              <select class="custom-select" name="kelas" id="kelas">
                <option disabled selected>=== Kelas ===</option>
                <?php
                $qjr = $db->tampil("kelas");
                while ($dt = $qjr->fetch(PDO::FETCH_ASSOC)) :
                ?>
                  <option value="<?= $dt['id_kelas'] ?>"><?= $dt['nama_kelas'] ?></option>
                <?php
                endwhile;
                ?>
              </select>
            </div>
            <div class="col-6">
              <label for="no">No telp</label>
              <input type="number" name="no_telp" class="form-control" id="no" placeholder="No Telepon">
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="alamat">Alamat</label>
              <textarea name="alamat" class="form-control" id="alamat" cols="20" rows="5" placeholder="Alamat Siswa"></textarea>
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
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php
require_once 'layout/footer.php';
?>