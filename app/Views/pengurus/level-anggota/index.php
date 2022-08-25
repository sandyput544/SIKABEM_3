<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <div class="col-12 d-flex justify-content-end mb-3">
    <div>
      <a href="/pengurus/level-anggota/tambah" class="btn btn-primary rounded-3"><i class="bi-plus-lg me-2"></i><span>Tambah Level</span></a>
      <a href="/pengurus/level-anggota/terhapus" class="btn btn-secondary rounded-3"><i class="bi-trash me-2"></i><span>Level Terhapus</span></a>
    </div>
  </div>
  <?php if (session()->getFlashdata('pesan')) : ?>
    <div class="col-12">
      <div class="alert alert-success d-flex align-items-center alert-dismissible col-12" role="alert">
        <i class="bi-check-circle-fill flex-shrink-0 me-2"></i>
        <?= session()->getFlashdata('pesan'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  <?php endif; ?>
  <div class="col-12">
    <div class="card text-dark shadow overflow-hidden rounded-4">
      <div class="card-header fw-bold fs-5 d-flex justify-content-between">
        <?= 'Tabel ' . $curr_page; ?>
        <a href="infoLevel" class="bi bi-info-circle text-secondary" data-bs-toggle="modal" data-bs-target="#infoLevel">
        </a>
      </div>
      <div class="card-body row g-3">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Departemen</th>
                <th scope="col">Nama Level</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($member_levels as $m) : ?>
                <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $m['dept_name']; ?></td>
                  <td><?= $m['memberlevel_name']; ?></td>
                  <td>
                    <?php if (session('role_id') == "1") : ?>
                      <a href="/pengurus/level-anggota/level-akses/<?= $m['memberlevel_id']; ?>" class="btn btn-sm btn-info bi-list-check"></a>
                    <?php endif; ?>
                    <a href="/pengurus/level-anggota/edit/<?= $m['memberlevel_id']; ?>" class="btn btn-sm btn-warning bi-pencil-fill"></a>
                    <form action="/pengurus/level-anggota/<?= $m['memberlevel_id']; ?>" class="d-inline" method="post">
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" class="btn btn-sm btn-danger bi-trash3-fill" onclick="return confirm('Apakah anda yakin ingin menghapus <?= $m['memberlevel_name']; ?>?');"></button>
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

<div class="modal fade" id="infoLevel" tabindex="-1" aria-labelledby="infoLevelModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoLevelModal">Info Level</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="row g-3">
            <div class="col-12">
              <p>Keterangan tombol aksi :</p>
              <ol>
                <li><button class="btn btn-primary"><i class="bi-plus-lg me-2"></i><span>Tambah Level</span></button> untuk menambah data level anggota.</li>
                <li><button class="btn btn-secondary"><i class="bi-trash me-2"></i><span>Level Terhapus</span></button> untuk melihat data level anggota yang terhapus.</li>
                <li><button class="btn btn-warning"><i class="bi-pencil me-2"></i></button> untuk mengubah salah satu data level anggota.</li>
                <li><button class="btn btn-danger"><i class="bi-trash me-2"></i></button> untuk menghapus level anggota.</li>
              </ol>
              <p>Cara menghapus secara permanen dari tabel level anggota yaitu dengan mengklik tombol <button class="btn btn-danger"><i class="bi-trash me-2"></i><span>Hapus Permanen</span></button></p>
            </div>
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