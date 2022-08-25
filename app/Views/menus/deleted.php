<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12 d-flex justify-content-between">
        <a href="<?= base_url('menu'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
        <div>
          <form action="<?= base_url('menu/pulihkanSemua'); ?>" class="d-inline" method="post">
            <input type="hidden" name="_method" value="PUT">
            <button type="submit" class="btn btn-primary rounded-3" onclick="return confirm('Apakah anda ingin memulihkan semua menu yang terhapus?');"><i class="bi-arrow-counterclockwise me-2"></i><span>Restore Semua</span></button>
          </form>
          <form action="<?= base_url('menu/hapusPermanenSemua'); ?>" class="d-inline" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger rounded-3" onclick="return confirm('Apakah anda yakin ingin benar-benar menghapus semua menu yang terhapus secara permanen?');"><i class="bi-trash3-fill me-2"></i><span>Hapus Semua</span></button>
          </form>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= $card; ?>
          </div>
          <div class="card-body row g-3">
            <div class="table-responsive">
              <table class="table align-middle">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Menu</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($menus as $m) : ?>
                    <tr>
                      <th scope="row"><?= $i++; ?></th>
                      <td><?= $m['nama_menu']; ?></td>
                      <td><span class="badge <?= ($m['menu_active'] == "1") ? "text-bg-success" : "text-bg-warning"; ?>">
                          <?= ($m['menu_active'] == "1") ? "Aktif" : "Nonaktif"; ?></span></td>
                      <td>
                        <form action="<?= base_url('menu/pulihkan/' . $m['kd_menu']); ?>" class="d-inline" method="post">
                          <input type="hidden" name="_method" value="PUT">
                          <button type="submit" class="btn btn-sm btn-primary bi-arrow-counterclockwise" onclick="return confirm('Apakah anda ingin memulihkan <?= $m['nama_menu']; ?>?');"></button>
                        </form>
                        <form action="<?= base_url('menu/hapusPermanen/' . $m['kd_menu']); ?>" class="d-inline" method="post">
                          <input type="hidden" name="_method" value="delete">
                          <button type="submit" class="btn btn-sm btn-danger bi-trash3-fill" onclick="return confirm('Apakah anda yakin ingin menghapus <?= $m['nama_menu']; ?> secara permanen?');"></button>
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

<?= $this->endSection(); ?>