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
          <table class="table align-middle">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Kategori</th>
                <th scope="col">Jumlah Arsip</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1;
              foreach ($categories as $c) : ?>
                <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $c['cat_name']; ?></td>
                  <td><?php
                          $cat_id = $c['id'];
                          echo  $getRows = $instance
                            ->where('cat_id', $cat_id)
                            ->countAllResults();
                          ?> arsip tersimpan</td>
                  <td>
                    <a href="<?= base_url('koleksi/list/' . $c['slug']); ?>" class="btn btn-sm btn-info bi-box-arrow-in-right"></a>
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