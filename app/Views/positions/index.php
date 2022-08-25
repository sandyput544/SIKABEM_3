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
          <a href="<?= site_url('jabatan/tambah'); ?>" class="btn btn-primary rounded-3"><i class="bi-plus-lg me-2"></i><span>Tambah Jabatan</span></a>
          <a href="<?= site_url('jabatan/terhapus'); ?>" class="btn btn-danger rounded-3"><i class="bi-trash3-fill me-2"></i><span>Jabatan Terhapus</span></a>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-3">
          <div class="card-header fw-bold fs-5">
            <?= $card; ?>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table align-middle">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Jabatan</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1;
                  foreach ($positions as $p) : ?>
                    <tr>
                      <th scope="row"><?= $i++; ?></th>
                      <td><?= $p['nama_jbt']; ?></td>
                      <td><span class="badge <?= ($p['jbt_active'] == "1") ? "text-bg-success" : "text-bg-warning"; ?>">
                          <?= ($p['jbt_active'] == "1") ? "Aktif" : "Nonaktif"; ?></span></td>
                      <td>
                        <a href="<?= base_url('jabatan/akses/' . $p['kd_jabatan']); ?>" class="btn btn-sm btn-info bi-menu-button-wide-fill
"></a>
                        <a href="<?= base_url('jabatan/edit/' . $p['kd_jabatan']); ?>" class="btn btn-sm btn-warning bi-pencil-fill"></a>
                        <form action="<?= base_url('jabatan/hapus/' . $p['kd_jabatan']); ?>" class="d-inline" method="post">
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class="btn btn-sm btn-danger bi-trash3-fill" onclick="return confirm('Apakah anda yakin ingin menghapus <?= $p['nama_jbt']; ?>?');"></button>
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