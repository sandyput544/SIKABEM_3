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
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5">
            <?= $card; ?>
          </div>
          <div class="card-body">
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
                    <td>Sisa <?= $p['jml_kursi']; ?> kursi</td>
                    <td><span class="badge <?= ($p['jbt_active'] == "1") ? "bg-success" : "bg-warning text-dark"; ?>">
                        <?= ($p['jbt_active'] == "1") ? "Aktif" : "Nonaktif"; ?></span></td>
                    <td>
                      <div class="dropdown">
                        <a class="text-secondary dropdown-toggle" href="#" role="button" id="dropdown_<?= $p['kd_jabatan']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                          Aksi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown_<?= $p['kd_jabatan']; ?>">
                          <li><a class="dropdown-item" href="<?= base_url('/jabatan/akses/' . $p['kd_jabatan']); ?>">Akses</a></li>
                          <li><a class="dropdown-item" href="<?= base_url('/jabatan/edit/' . $p['kd_jabatan']); ?>">Ubah</a></li>
                          <?php if (session('id_jabatan') !== $p['kd_jabatan']) : ?>
                            <li>
                              <div>
                                <form id="deleteMe_<?= $p['kd_jabatan']; ?>" action="<?= base_url('jabatan/hapus/' . $p['kd_jabatan']); ?>" method="post">
                                  <input type="hidden" name="_method" value="DELETE">
                                  <a href="javascript:void(0);" onclick="return confirmation('<?= $p['nama_jbt']; ?>','<?= $p['kd_jabatan']; ?>');" class="dropdown-item">Hapus</a>
                                </form>
                              </div>
                            </li>
                          <?php endif; ?>
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
  function confirmation(nama, id) {
    if (confirm("Yakin ingin menghapus data jabatan : " + nama + "?")) {
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