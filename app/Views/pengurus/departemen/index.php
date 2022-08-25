<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <div class="col-12">
      <div class="alert alert-success d-flex align-items-center alert-dismissible" role="alert">
        <i class="bi-check-circle-fill flex-shrink-0 me-2"></i>
        <?= session()->getFlashdata('pesan'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12 d-flex">
        <div class="ms-auto">
          <a href="<?= base_url() . '/pengurus/departemen/tambah'; ?>" class="btn btn-primary rounded-3"><i class="bi-plus-lg"></i><span>Tambah Data</span></a>
          <a href="<?= base_url() . '/pengurus/departemen/terhapus'; ?>" class="btn btn-secondary rounded-3"><i class="bi-trash3-fill me-2"></i><span>Data Terhapus</span></a>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= 'Tabel ' . $curr_page; ?>
            <a href="infoDept" class="bi bi-info-circle text-secondary" data-bs-toggle="modal" data-bs-target="#infoDept"></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table align-middle">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Departemen</th>
                    <th scope="col">Akronim</th>
                    <th scope="col">Logo</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1;
                  foreach ($departments as $d) : ?>
                    <tr>
                      <th scope="row"><?= $i++; ?></th>
                      <td><?= $d['dept_name']; ?></td>
                      <td><?= $d['dept_acronim']; ?></td>
                      <td><img src="/assets/img/dept_logo_img/<?= $d['dept_logo_file']; ?>" alt="" class="img-logo-preview"></td>
                      <td>
                        <a href="/pengurus/departemen/edit/<?= $d['dept_id']; ?>" class="btn btn-sm btn-warning bi-pencil-fill"></a>
                        <form action="/pengurus/departemen/<?= $d['dept_id']; ?>" class="d-inline" method="post">
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class="btn btn-sm btn-danger bi-trash3-fill" onclick="return confirm('Apakah anda yakin ingin menghapus <?= $d['dept_name']; ?>?');"></button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="infoDept" tabindex="-1" aria-labelledby="infoDeptModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoDeptModal">Info Departemen Terhapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-12">
            <<p>Keterangan tombol aksi :</p>
              <ol>
                <li><button class="btn btn-primary"><i class="bi-plus-lg me-2"></i><span>Tambah Data</span></button> untuk menambah anggota.</li>
                <li><button class="btn btn-secondary"><i class="bi-trash me-2"></i><span>Data Terhapus</span></button> untuk melihat departemen yang terhapus.</li>
                <li><button class="btn btn-warning"><i class="bi-pencil-fill"></i></button> untuk memperbarui data salah satu departemen.</li>
                <li><button class="btn btn-danger"><i class="bi-trash3-fill"></i></button> untuk menghapus data salah satu departemen.</li>
              </ol>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Mengerti</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>