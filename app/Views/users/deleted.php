<?php helper('bem'); ?>
<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12 d-flex justify-content-between">
        <a href="<?= base_url('user'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
        <div>
          <form action="<?= base_url('user/pulihkanSemua'); ?>" class="d-inline" method="post">
            <input type="hidden" name="_method" value="PUT">
            <button type="submit" class="btn btn-primary rounded-3" onclick="return confirm('Apakah anda ingin benar-benar memulihkan semua user yang terhapus?');"><i class="bi-arrow-counterclockwise me-2"></i><span>Restore Semua</span></button>
          </form>
          <form action="<?= base_url('user/hapusPermanenSemua'); ?>" class="d-inline" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger rounded-3" onclick="return confirm('Apakah anda yakin ingin benar-benar menghapus semua user yang terhapus secara permanen?');"><i class="bi-trash3-fill me-2"></i><span>Hapus Semua</span></button>
          </form>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-3">
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= $card; ?>
          </div>
          <div class="card-body row g-3">
            <div class="table-responsive">
              <table class="table align-middle">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama User</th>
                    <th scope="col">Posisi</th>
                    <th scope="col">Tanggal Terhapus</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($users as $u) : ?>
                    <tr>
                      <th scope="row"><?= $i++; ?></th>
                      <td><?= $u['full_name']; ?></td>
                      <td><?= $u['pos_name']; ?></td>
                      <td><?= $u['deleted_at']; ?></td>
                      <td><span class="badge <?= ($u['is_active'] == "1") ? "text-bg-success" : "text-bg-warning"; ?>">
                          <?= ($u['is_active'] == "1") ? "Aktif" : "Nonaktif"; ?></span></td>
                      <td>
                        <form action="<?= base_url('user/pulihkan/' . $u['id']); ?>" class="d-inline" method="post">
                          <input type="hidden" name="_method" value="PUT">
                          <button type="submit" class="btn btn-sm btn-primary bi-arrow-counterclockwise" onclick="return confirm('Apakah anda ingin mengembalikan <?= $u['full_name']; ?>?');"></button>
                        </form>
                        <form action="<?= base_url('user/hapusPermanen/' . $u['id']); ?>" class="d-inline" method="post">
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class="btn btn-sm btn-danger bi-trash3-fill" onclick="return confirm('Apakah anda yakin ingin menghapus user <?= $u['full_name']; ?> secara permanen?');"></button>
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