<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12 d-flex justify-content-between">
        <a href="<?= base_url('jabatan'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
        <div>
          <form action="<?= base_url('jabatan/pulihkanSemua'); ?>" class="d-inline" method="post">
            <input type="hidden" name="_method" value="PUT">
            <button type="submit" class="btn btn-primary rounded-3" onclick="return confirm('Apakah anda ingin benar-benar memulihkan semua jabatan yang terhapus?');"><i class="bi-arrow-counterclockwise me-2"></i><span>Pulihkan Semua</span></button>
          </form>
          <form action="<?= base_url('jabatan/hapusPermanenSemua'); ?>" class="d-inline" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger rounded-3" onclick="return confirm('Apakah anda yakin ingin benar-benar menghapus semua posisi yang terhapus secara permanen?');"><i class="bi-trash3-fill me-2"></i><span>Hapus Semua</span></button>
          </form>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= $card; ?>
          </div>
          <div class="card-body row g-3">
            <table id="jbt" class="table align-middle">
              <thead>
                <tr>
                  <th scope="col">Nama Jabatan</th>
                  <th scope="col">Sisa Kursi</th>
                  <th scope="col">Status</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($positions as $p) : ?>
                  <tr>
                    <td><?= $p['nama_jbt']; ?></td>
                    <td><?= $p['jml_kursi']; ?></td>
                    <td><span class="badge <?= ($p['jbt_active'] == "1") ? "bg-success" : "bg-warning text-dark"; ?>">
                        <?= ($p['jbt_active'] == "1") ? "Aktif" : "Nonaktif"; ?></span></td>
                    <td>
                      <div class="dropdown">
                        <a class="text-secondary dropdown-toggle" href="#" role="button" id="dropdown<?= $p['kd_jabatan']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                          Aksi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown<?= $p['kd_jabatan']; ?>">
                          <li>
                            <div>
                              <form id="restoreMe_<?= $p['kd_jabatan']; ?>" action="<?= base_url('jabatan/pulihkan/' . $p['kd_jabatan']) ?>" method="post">
                                <input type="hidden" name="_method" value="PUT">
                                <a href="javascript:void(0);" onclick="return restConf('<?= $p['nama_jbt']; ?>','<?= $p['kd_jabatan']; ?>');" class="dropdown-item">Pulihkan</a>
                              </form>
                            </div>
                          </li>
                          <li>
                            <div>
                              <form id="deleteMe_<?= $p['kd_jabatan']; ?>" action="<?= base_url('jabatan/hapusPermanen/' . $p['kd_jabatan']) ?>" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="javascript:void(0);" onclick="return delConf('<?= $p['nama_jbt']; ?>','<?= $p['kd_jabatan']; ?>');" class="dropdown-item">Hapus</a>
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
    if (confirm("Yakin ingin memulihkan data jabatan : " + nama + "?")) {
      document.getElementById('restoreMe_' + id).submit();
    } else {
      return false;
    }
  }

  function delConf(nama, id) {
    if (confirm("Yakin ingin menghapus permanen data jabatan : " + nama + "?")) {
      document.getElementById('deleteMe_' + id).submit();
    } else {
      return false;
    }
  }
  $(document).ready(function() {
    $('#jbt').DataTable();
  });
</script>
<?= $this->endSection(); ?>