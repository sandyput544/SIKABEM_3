<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12 d-flex justify-content-between">
        <a href="<?= base_url('arsip'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
        <div>
          <form action="<?= base_url('arsip/pulihkanSemua'); ?>" class="d-inline" method="post">
            <input type="hidden" name="_method" value="PUT">
            <button type="submit" class="btn btn-primary rounded-3" onclick="return confirm('Apakah anda ingin memulihkan semua arsip yang terhapus?');"><i class="bi-arrow-counterclockwise me-2"></i><span>Restore Semua</span></button>
          </form>
          <form action="<?= base_url('arsip/hapusPermanenSemua'); ?>" class="d-inline" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger rounded-3" onclick="return confirm('Apakah anda yakin ingin benar-benar menghapus semua arsip yang terhapus secara permanen?');"><i class="bi-trash3-fill me-2"></i><span>Hapus Semua</span></button>
          </form>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= $card; ?>
          </div>
          <div class="card-body row g-3">
            <table id="arsip" class="table align-middle table-striped">
              <thead>
                <tr>
                  <th scope="col">Kategori</th>
                  <th scope="col">Nomor Arsip</th>
                  <th scope="col">Nama Arsip</th>
                  <th scope="col">Pembuat Arsip</th>
                  <th scope="col">Tanggal Dihapus</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($archives as $a) : ?>
                  <tr>
                    <td><?= $a['kategori']; ?></td>
                    <td><?= $a['nomor_arsip']; ?></td>
                    <td><?= $a['nama_arsip']; ?></td>
                    <td><?= $a['pembuat']; ?></td>
                    <td><?= $a['tgl_delete']; ?></td>
                    <td>
                      <div class="dropdown">
                        <a class="text-secondary dropdown-toggle" href="#" role="button" id="dropdown<?= $a['kd_arsip']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                          Aksi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown<?= $a['kd_arsip']; ?>">
                          <li>
                            <div>
                              <form id="restoreMe_<?= $a['kd_arsip']; ?>" action="<?= base_url('arsip/pulihkan/' . $a['kd_arsip']) ?>" method="post">
                                <input type="hidden" name="_method" value="PUT">
                                <a href="javascript:void(0);" onclick="return restConf('<?= $a['nama_arsip']; ?>','<?= $a['nomor_arsip']; ?>','<?= $a['kd_arsip']; ?>');" class="dropdown-item">Pulihkan</a>
                              </form>
                            </div>
                          </li>
                          <li>
                            <div>
                              <form id="deleteMe_<?= $a['kd_arsip']; ?>" action="<?= base_url('arsip/hapusPermanen/' . $a['kd_arsip']) ?>" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="javascript:void(0);" onclick="return delConf('<?= $a['nama_arsip']; ?>','<?= $a['nomor_arsip']; ?>','<?= $a['kd_arsip']; ?>');" class="dropdown-item">Hapus</a>
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
  function restConf(nama, nomor, id) {
    if (confirm("Yakin ingin memulihkan data arsip : " + nama + " dengan nomor arsip : " + nomor + "?")) {
      document.getElementById('restoreMe_' + id).submit();
    } else {
      return false;
    }
  }

  function delConf(nama, nomor, id) {
    if (confirm("Yakin ingin menghapus permanen data arsip : " + nama + " dengan nomor arsip : " + nomor + "?")) {
      document.getElementById('deleteMe_' + id).submit();
    } else {
      return false;
    }
  }
  $(document).ready(function() {
    $('#arsip').DataTable();
  });
</script>
<?= $this->endSection(); ?>