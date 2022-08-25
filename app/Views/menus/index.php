<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12 d-flex">
        <div class="ms-auto">
          <a href="<?= base_url('menu/tambah'); ?>" class="btn btn-primary rounded-3"><i class="bi-plus-lg"></i><span>Tambah Menu</span></a>
          <a href="<?= base_url('menu/terhapus'); ?>" class="btn btn-danger rounded-3"><i class="bi-trash3-fill me-2"></i><span>Menu Terhapus</span></a>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5">
            <?= $card; ?>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="tabel" class="table align-middle">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Menu</th>
                    <th scope="col">Url</th>
                    <th scope="col">Icon</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1;
                  foreach ($menus as $m) : ?>
                    <tr>
                      <th scope="row"><?= $i++; ?></th>
                      <td><?= $m['nama_menu']; ?></td>
                      <td><?= $m['url_menu']; ?></td>
                      <td><i class="<?= $m['ikon_menu']; ?>"></i></td>
                      <td><span class="badge <?= ($m['menu_active'] == "1") ? "text-bg-success" : "text-bg-warning"; ?>">
                          <?= ($m['menu_active'] == "1") ? "Aktif" : "Nonaktif"; ?></span></td>
                      <td>
                        <a href="<?= base_url('menu/edit/' . $m['kd_menu']); ?>" class="btn btn-sm btn-warning bi-pencil-fill"></a>
                        <?php if ($m['nama_menu'] != "Master Menu") : ?>
                          <form action="<?= base_url('menu/hapus/' . $m['kd_menu']); ?>" class="d-inline" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger bi-trash3-fill" onclick="return confirm('Apakah anda yakin ingin menghapus <?= $m['nama_menu']; ?>?');"></button>
                          </form>
                        <?php endif; ?>
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
<?= $this->section('script'); ?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#tabel').DataTable();
  });
</script>
<?= $this->endSection(); ?>