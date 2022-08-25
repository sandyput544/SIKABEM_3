<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12 d-flex justify-content-end">
        <div>
          <a href="<?= base_url('/user/tambah'); ?>" class="btn btn-primary rounded-3"><i class="bi-plus-lg me-2"></i><span>Tambah User</span></a>
          <a href="<?= base_url('/user/terhapus'); ?>" class="btn btn-danger rounded-3"><i class="bi-trash3-fill me-2"></i><span>User Terhapus</span></a>
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
                    <th scope="col">Nama Lengkap</th>
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
                      <td><?= $u['full_name'] ?></td>
                      <td><span class="badge <?= ($u['is_active'] == "1") ? "text-bg-success" : "text-bg-warning"; ?>">
                          <?= ($u['is_active'] == "1") ? "Aktif" : "Nonaktif"; ?></span></td>
                      <td>
                        <form action="<?= base_url('user/hapus/' . $u['id']) ?>" class="d-inline" method="post">
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class="btn btn-sm btn-danger bi-trash3-fill" onclick="return confirm('Apakah anda yakin ingin menghapus <?= $u['full_name'] ?>?');"></button>
                        </form>
                        <a href="<?= base_url('/user/edit/' . $u['id']) ?>" class="btn btn-sm btn-warning bi-pencil-fill"></a>
                        <a href="<?= base_url('/user/detail/' . $u['id']) ?>" class="btn btn-sm btn-info bi-eye-fill"></a>
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