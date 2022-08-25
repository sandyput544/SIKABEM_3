<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="<?= base_url('koleksi'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-12">
    <div class="card text-dark shadow overflow-hidden rounded-4">
      <div class="card-header fw-bold fs-5 d-flex justify-content-between">
        <?= $card; ?>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Arsip</th>
                <th scope="col">Tanggal Upload</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1;
              foreach ($archives as $a) : ?>
                <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $a['archive_name']; ?></td>
                  <td><?= $a['updated_at']; ?></td>
                  <td>
                    <a href="<?= base_url('koleksi/detail/' . $a['file_name']); ?>" class="btn btn-sm btn-info bi-eye-fill"></a>
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