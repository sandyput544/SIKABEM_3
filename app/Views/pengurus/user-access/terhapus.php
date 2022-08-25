<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12 d-flex justify-content-between">
    <a href="/pengurus/menu" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
    <div>
      <form action="/pengurus/menu/restoreAll" class="d-inline" method="post">
        <input type="hidden" name="_method" value="PUT">
        <button type="submit" class="btn btn-primary rounded-3" onclick="return confirm('Apakah anda ingin mengembalikan semua data yang terhapus?');"><i class="bi-arrow-counterclockwise me-2"></i><span>Kembalikan Semua Departemen</span></button>
      </form>
      <form action="/pengurus/menu/permanently-delete" class="d-inline" method="post">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-danger rounded-3" onclick="return confirm('Apakah anda yakin ingin benar-benar menghapus permanen semua menu yang terhapus?');"><i class="bi-trash3-fill me-2"></i><span>Hapus Permanen</span></button>
      </form>
    </div>
  </div>
  <div class="col-12">
    <div class="card text-dark shadow overflow-hidden rounded-4">
      <div class="card-header fw-bold fs-5 d-flex justify-content-between">
        <?= 'Tabel ' . $curr_page; ?>
        <a href="infoDeletedMenu" class="bi bi-info-circle text-secondary" data-bs-toggle="modal" data-bs-target="#infoDeletedMenu">
        </a>
      </div>
      <div class="card-body row g-3">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Menu</th>
                <th scope="col">Icon</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach ($usermenus as $u) : ?>
                <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $u['title']; ?></td>
                  <td><i class="<?= $u['icon']; ?>"></i></td>
                  <td>
                    <form action="/pengurus/menu/restore/<?= $u['menu_id']; ?>" class="d-inline" method="post">
                      <input type="hidden" name="_method" value="PUT">
                      <button type="submit" class="btn btn-sm btn-primary bi-arrow-counterclockwise" onclick="return confirm('Apakah anda ingin mengembalikan <?= $u['title']; ?>?');"></button>
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

<div class="modal fade" id="infoDeletedMenu" tabindex="-1" aria-labelledby="infoDeletedMenuModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoDeletedMenuModal">Info Menu Terhapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-12">
            <p>Cara mengembalikan menu yang sudah terhapus :</p>
            <ol>
              <li><button class="btn btn-primary"><i class="bi-arrow-counterclockwise me-2"></i><span>Kembalikan Semua Menu</span></button> untuk mengembalikan semua menu yang terhapus.</li>
              <li><button class="btn btn-primary bi-arrow-counterclockwise"></button> untuk mengembalikan menu satu-persatu</li>
            </ol>
            <p>Cara menghapus secara permanen dari tabel menu yaitu dengan mengklik tombol <button class="btn btn-danger"><i class="bi-trash3-fill me-2"></i><span>Hapus Permanen</span></button></p>
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