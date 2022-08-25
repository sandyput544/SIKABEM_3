<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12 d-flex justify-content-between">
    <a href="/pengurus/anggota/level-anggota" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
    <div>
      <form action="/pengurus/level-anggota/restoreAll" class="d-inline" method="post">
        <input type="hidden" name="_method" value="PUT">
        <button type="submit" class="btn btn-primary rounded-3" onclick="return confirm('Apakah anda ingin benar-benar menghapus level anggota secara permanen?');"><i class="bi-arrow-counterclockwise me-2"></i><span>Kembalikan Semua Level</span></button>
      </form>
      <form action="/pengurus/level-anggota/permanently-delete" class="d-inline" method="post">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-danger rounded-3" onclick="return confirm('Apakah anda yakin ingin benar-benar menghapus level anggota secara permanen?');"><i class="bi-trash me-2"></i><span>Hapus Permanen</span></button>
      </form>
    </div>
  </div>
  <div class="col-12">
    <div class="card text-dark shadow overflow-hidden rounded-3">
      <div class="card-header fw-bold fs-5 d-flex justify-content-between">
        <?= 'Tabel ' . $curr_page; ?>
        <a href="infoDeletedLevel" class="bi bi-info-circle text-secondary" data-bs-toggle="modal" data-bs-target="#infoDeletedLevel">
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
              foreach ($memberslevel as $m) : ?>
                <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $m['dept_name']; ?></td>
                  <td><?= $m['memberlevel_name']; ?></td>
                  <td>
                    <form action="/pengurus/level-anggota/restore/<?= $m['memberlevel_id']; ?>" class="d-inline" method="post">
                      <input type="hidden" name="_method" value="PUT">
                      <button type="submit" class="btn btn-sm btn-primary bi-arrow-counterclockwise" onclick="return confirm('Apakah anda ingin mengembalikan <?= $m['memberlevel_name']; ?>?');"></button>
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

<div class="modal fade" id="infoDeletedLevel" tabindex="-1" aria-labelledby="infoDeletedLevelModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoDeletedLevelModal">Info Level</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-12">
            <p>Cara mengembalikan level anggota yang sudah terhapus :</p>
            <ol>
              <li>Klik tombol <button class="btn btn-primary"><i class="bi-arrow-counterclockwise me-2"></i><span>Kembalikan Semua Level</span></button> untuk mengembalikan semua level yang terhapus.</li>
              <li>Kembalikan secara satu persatu dengan mengklik tombol <button class="btn btn-primary bi-arrow-counterclockwise"></button></li>
            </ol>
            <p>Cara menghapus secara permanen dari tabel level anggota yaitu dengan mengklik tombol <button class="btn btn-danger"><i class="bi-trash me-2"></i><span>Hapus Permanen</span></button></p>
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