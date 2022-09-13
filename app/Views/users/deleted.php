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
            <button type="submit" class="btn btn-primary rounded-3" onclick="return confirm('Apakah anda ingin benar-benar memulihkan semua data user yang terhapus?');"><i class="bi-arrow-counterclockwise me-2"></i><span>Pulihkan Semua</span></button>
          </form>
          <form action="<?= base_url('user/hapusPermanenSemua'); ?>" class="d-inline" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger rounded-3" onclick="return confirm('Apakah anda yakin ingin benar-benar menghapus permanen semua data user yang terhapus secara permanen?');"><i class="bi-trash3-fill me-2"></i><span>Hapus Semua</span></button>
          </form>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= $card; ?>
          </div>
          <div class="card-body">
            <table id="users" class="table align-middle table-striped">
              <thead>
                <tr>
                  <th scope="col">Nama Lengkap</th>
                  <th scope="col">Jabatan</th>
                  <th scope="col">Status</th>
                  <th scope="col">Tanggal Dihapus</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($users as $u) : ?>
                  <tr>
                    <td><?= $u['nama_user']; ?></td>
                    <td><?= ($u['id_jbt'] == 0) ? "Belum memiliki jabatan" : $u['jabatan']; ?></td>
                    <td><span class="badge <?= ($u['user_active'] == "1") ? "bg-success" : "bg-warning text-dark"; ?>">
                        <?= ($u['user_active'] == "1") ? "Aktif" : "Nonaktif"; ?></span></td>
                    <td><?= $u['tgl_delete']; ?></td>
                    <td>
                      <div class="dropdown">
                        <a class="text-secondary dropdown-toggle" href="#" role="button" id="dropdown<?= $u['kd_user']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                          Aksi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown<?= $u['kd_user']; ?>">
                          <li>
                            <div>
                              <form id="restoreMe_<?= $u['kd_user']; ?>" action="<?= base_url('user/pulihkan/' . $u['kd_user']) ?>" method="post">
                                <input type="hidden" name="_method" value="PUT">
                                <a href="javascript:void(0);" onclick="return restConf('<?= $u['nama_user']; ?>','<?= $u['kd_user']; ?>');" class="dropdown-item">Pulihkan</a>
                              </form>
                            </div>
                          </li>
                          <li>
                            <div>
                              <form id="deleteMe_<?= $u['kd_user']; ?>" action="<?= base_url('user/hapusPermanen/' . $u['kd_user']) ?>" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="javascript:void(0);" onclick="return delConf('<?= $u['nama_user']; ?>','<?= $u['kd_user']; ?>');" class="dropdown-item">Hapus</a>
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
    if (confirm("Yakin ingin memulihkan data user : " + nama + "?")) {
      document.getElementById('restoreMe_' + id).submit();
    } else {
      return false;
    }
  }

  function delConf(nama, id) {
    if (confirm("Yakin ingin menghapus permanen data user : " + nama + "?")) {
      document.getElementById('deleteMe_' + id).submit();
    } else {
      return false;
    }
  }
  $(document).ready(function() {
    $('#users').DataTable();
  });
</script>
<?= $this->endSection(); ?>