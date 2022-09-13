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
            <button type="submit" class="btn btn-primary rounded-3" onclick="return confirm('Apakah anda ingin memulihkan semua menu yang terhapus?');"><i class="bi-arrow-counterclockwise me-2"></i><span>Pulihkan Semua</span></button>
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
            <table id="menu" class="table align-middle table-striped">
              <thead>
                <tr>
                  <th scope="col">Nama Menu</th>
                  <th scope="col">Url Menu</th>
                  <th scope="col">Ikon Menu</th>
                  <th scope="col">Status</th>
                  <th scope="col">Tanggal Dihapus</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($menus as $m) : ?>
                  <tr>
                    <td><?= $m['nama_menu']; ?></td>
                    <td><?= $m['url_menu']; ?></td>
                    <td><i class="<?= $m['ikon_menu']; ?>"></i></td>
                    <td><span class="badge <?= ($m['menu_active'] == "1") ? "bg-success" : "bg-warning text-dark"; ?>">
                        <?= ($m['menu_active'] == "1") ? "Aktif" : "Nonaktif"; ?></span></td>
                    <td><?= $m['deleted_at']; ?></td>
                    <td>
                      <div class="dropdown">
                        <a class="text-secondary dropdown-toggle" href="#" role="button" id="dropdown<?= $m['kd_menu']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                          Aksi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown<?= $m['kd_menu']; ?>">
                          <li>
                            <div>
                              <form id="restoreMe_<?= $m['kd_menu']; ?>" action="<?= base_url('menu/pulihkan/' . $m['kd_menu']) ?>" method="post">
                                <input type="hidden" name="_method" value="PUT">
                                <a href="javascript:void(0);" onclick="return restConf('<?= $m['nama_menu']; ?>','<?= $m['kd_menu']; ?>');" class="dropdown-item">Pulihkan</a>
                              </form>
                            </div>
                          </li>
                          <li>
                            <div>
                              <form id="deleteMe_<?= $m['kd_menu']; ?>" action="<?= base_url('menu/hapusPermanen/' . $m['kd_menu']) ?>" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="javascript:void(0);" onclick="return delConf('<?= $m['nama_menu']; ?>','<?= $m['kd_menu']; ?>');" class="dropdown-item">Hapus</a>
                              </form>
                            </div>
                          </li>
                        </ul>
                      </div>
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

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
  function restConf(nama, id) {
    if (confirm("Yakin ingin memulihkan data menu : " + nama + "?")) {
      document.getElementById('restoreMe_' + id).submit();
    } else {
      return false;
    }
  }

  function delConf(nama, id) {
    if (confirm("Yakin ingin menghapus permanen data menu : " + nama + "?")) {
      document.getElementById('deleteMe_' + id).submit();
    } else {
      return false;
    }
  }
  $(document).ready(function() {
    $('#menu').DataTable();
  });
</script>
<?= $this->endSection(); ?>