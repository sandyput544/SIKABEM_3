<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12 d-flex">
        <div class="me-auto">
          <a href="<?= base_url('surat-keluar'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
        </div>
        <div class="ms-auto">
          <a href="<?= base_url('jenis-surat/tambah'); ?>" class="btn btn-primary rounded-3"><i class="bi-plus-lg"></i><span>Tambah Jenis Surat</span></a>
          <a href="<?= base_url('jenis-surat/terhapus'); ?>" class="btn btn-danger rounded-3"><i class="bi-trash3-fill me-2"></i><span>Jenis Surat Terhapus</span></a>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= $card; ?>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="mt" class="table align-middle table-striped">
                <thead>
                  <tr>
                    <th scope="col">Kode Surat</th>
                    <th scope="col">Nama Jenis Surat</th>
                    <th scope="col">Tanggal Diubah</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1;
                  foreach ($mailtype as $m) : ?>
                    <tr>
                      <td><?= $m['kode_surat']; ?></td>
                      <td><?= $m['nama_jenis']; ?></td>
                      <td><?= $m['updated_at']; ?></td>
                      <td>
                        <div class="dropdown">
                          <a class="text-secondary dropdown-toggle" href="#" role="button" id="dropdown<?= $m['kd_jenissurat']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                            Aksi
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdown<?= $m['kd_jenissurat']; ?>">
                            <li><a class="dropdown-item" href="<?= base_url('/jenis-surat/edit/' . $m['kd_jenissurat']) ?>">Ubah</a></li>
                            <li>
                              <div>
                                <form id="deleteMe" action="<?= base_url('jenis-surat/hapus/' . $m['kd_jenissurat']) ?>" method="post">
                                  <input type="hidden" name="_method" value="DELETE">
                                  <a href="javascript:void(0);" onclick="return confirmation('<?= $m['nama_jenis']; ?>');" class="dropdown-item">Hapus</a>
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
</div>
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
  function confirmation(nama) {
    if (confirm("Yakin ingin menghapus data jenis surat : " + nama + "?")) {
      document.getElementById('deleteMe').submit();
    } else {
      return false;
    }
  }
  $(document).ready(function() {
    $('#mt').DataTable();
  });
</script>
<?= $this->endSection(); ?>