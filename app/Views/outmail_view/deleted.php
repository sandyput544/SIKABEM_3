<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12 d-flex justify-content-between">
        <a href="<?= base_url('surat-keluar'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
        <div>
          <form action="<?= base_url('surat-keluar/pulihkanSemua'); ?>" class="d-inline" method="post">
            <input type="hidden" name="_method" value="PUT">
            <button type="submit" class="btn btn-primary rounded-3" onclick="return confirm('Apakah anda ingin benar-benar memulihkan semua data surat keluar yang terhapus?');"><i class="bi-arrow-counterclockwise me-2"></i><span>Pulihkan Semua</span></button>
          </form>
          <form action="<?= base_url('surat-keluar/hapusPermanenSemua'); ?>" class="d-inline" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger rounded-3" onclick="return confirm('Apakah anda yakin ingin benar-benar menghapus permanen semua data surat keluar yang terhapus secara permanen?');"><i class="bi-trash3-fill me-2"></i><span>Hapus Semua</span></button>
          </form>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= $card; ?>
          </div>
          <div class="card-body">
            <table id="mail" class="table align-middle table-striped">
              <thead>
                <tr>
                  <th scope="col">Jenis Surat</th>
                  <th scope="col">Nomor Surat</th>
                  <th scope="col">Nama Pembuat</th>
                  <th scope="col">Tanggal Dihapus</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($mail as $m) : ?>
                  <tr>
                    <td><?= $m['nama_jenis']; ?></td>
                    <td><?= $m['nomor_surat']; ?></td>
                    <td><?= ($m['id_user'] = 0) ? $m['nama_user'] : "-"; ?></td>
                    <td><?= $m['tgl_delete']; ?></td>
                    <td>
                      <div class="dropdown">
                        <a class="text-secondary dropdown-toggle" href="#" role="button" id="dropdown<?= $m['kd_suratkeluar']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                          Aksi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown<?= $m['kd_suratkeluar']; ?>">
                          <li>
                            <div>
                              <form id="restoreMe_<?= $m['kd_suratkeluar']; ?>" action="<?= base_url('surat-keluar/pulihkan/' . $m['kd_suratkeluar']) ?>" method="post">
                                <input type="hidden" name="_method" value="PUT">
                                <a href="javascript:void(0);" onclick="return restConf('<?= $m['nama_jenis']; ?>','<?= $m['nomor_surat']; ?>','<?= $m['kd_suratkeluar']; ?>');" class="dropdown-item">Pulihkan</a>
                              </form>
                            </div>
                          </li>
                          <li>
                            <div>
                              <form id="deleteMe_<?= $m['kd_suratkeluar']; ?>" action="<?= base_url('surat-keluar/hapusPermanen/' . $m['kd_suratkeluar']) ?>" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="javascript:void(0);" onclick="return delConf('<?= $m['nama_jenis']; ?>','<?= $m['nomor_surat']; ?>','<?= $m['kd_suratkeluar']; ?>');" class="dropdown-item">Hapus</a>
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
    if (confirm("Yakin ingin memulihkan data surat keluar : " + nama + " dengan nomor surat : " + nomor + "?")) {
      document.getElementById('restoreMe_' + id).submit();
    } else {
      return false;
    }
  }

  function delConf(nama, nomor, id) {
    if (confirm("Yakin ingin menghapus permanen data surat keluar : " + nama + " dengan nomor surat : " + nomor + "?")) {
      document.getElementById('deleteMe_' + id).submit();
    } else {
      return false;
    }
  }
  $(document).ready(function() {
    $('#mail').DataTable({
      order: [
        [1, 'desc']
      ],
    });
  });
</script>
<?= $this->endSection(); ?>