<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <div class="card text-dark shadow overflow-hidden rounded-4">
      <div class="card-header fw-bold fs-5 d-flex justify-content-between">
        <?= $card; ?>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="arsip" class="table align-middle table-striped">
            <thead>
              <tr>
                <th scope="col">Kategori</th>
                <th scope="col">Nomor Arsip</th>
                <th scope="col">Nama Arsip</th>
                <th scope="col">Tanggal Dibuat</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($archives as $a) : ?>
                <tr>
                  <td><?= ($a['kd_kategori'] != 0) ? $a['nama_kat'] : '-'; ?></td>
                  <td><?= $a['nomor_arsip']; ?></td>
                  <td><?= $a['nama_arsip']; ?></td>
                  <td><?= $a['tgl_buat']; ?></td>
                  <td>
                    <a href="<?= base_url('koleksi/detail/' . $a['nama_file']); ?>" class="btn btn-sm btn-info bi-eye-fill text-white"></a>
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
<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
  $(document).ready(function() {
    $('#arsip').DataTable();
  });
</script>
<?= $this->endSection(); ?>