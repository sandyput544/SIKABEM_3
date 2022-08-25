<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12 d-flex justify-content-between">
        <a href="<?= base_url('kategori'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
        <div>
          <form action="<?= base_url('kategori/pulihkanSemua'); ?>" class="d-inline" method="post">
            <input type="hidden" name="_method" value="PUT">
            <button type="submit" class="btn btn-primary rounded-3" onclick="return confirm('Apakah anda ingin memulihkan semua kategori yang terhapus?');"><i class="bi-arrow-counterclockwise me-2"></i><span>Restore Semua</span></button>
          </form>
          <form action="<?= base_url('kategori/hapusPermanenSemua'); ?>" class="d-inline" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger rounded-3" onclick="return confirm('Apakah anda yakin ingin benar-benar menghapus semua kategori yang terhapus secara permanen?');"><i class="bi-trash3-fill me-2"></i><span>Hapus Semua</span></button>
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
                <thead class="table-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Menu</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($categories as $c) : ?>
                    <tr>
                      <th scope="row"><?= $i++; ?></th>
                      <td><?= $c['cat_name']; ?></td>
                      <td>
                        <form action="<?= base_url('kategori/pulihkan/' . $c['id']); ?>" class="d-inline" method="post">
                          <input type="hidden" name="_method" value="PUT">
                          <button type="submit" class="btn btn-sm btn-primary bi-arrow-counterclockwise" onclick="return confirm('Apakah anda ingin memulihkan <?= $c['cat_name']; ?>?');"></button>
                        </form>
                        <form action="<?= base_url('kategori/hapusPermanen/' . $c['id']); ?>" class="d-inline" method="post">
                          <input type="hidden" name="_method" value="delete">
                          <button type="submit" class="btn btn-sm btn-danger bi-trash3-fill" onclick="return confirm('Apakah anda yakin ingin menghapus <?= $c['cat_name']; ?> secara permanen?');"></button>
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