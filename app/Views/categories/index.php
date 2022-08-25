<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12 d-flex">
        <div class="ms-auto">
          <a href="<?= base_url('kategori/tambah'); ?>" class="btn btn-primary rounded-3"><i class="bi-plus-lg"></i><span>Tambah Kategori</span></a>
          <a href="<?= base_url('kategori/terhapus'); ?>" class="btn btn-danger rounded-3"><i class="bi-trash3-fill me-2"></i><span>Kategori Terhapus</span></a>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= $card; ?>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table align-middle">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Kategori</th>
                    <th scope="col">Jumlah Arsip</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1;
                  foreach ($categories as $c) : ?>
                    <tr>
                      <th scope="row"><?= $i++; ?></th>
                      <td><?= $c['nama_kat']; ?></td>
                      <td><?php
                          $cat_id = $c['kd_kategori'];
                          echo  $getRows = $instance
                            ->where('kd_kategori', $cat_id)
                            ->countAllResults();
                          ?> arsip tersimpan</td>
                      <td>
                        <form action="<?= base_url('kategori/hapus/' . $c['kd_kategori']); ?>" class="d-inline" method="post">
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class="btn btn-sm btn-danger bi-trash3-fill" onclick="return confirm('Apakah anda yakin ingin menghapus <?= $c['nama_kat']; ?>?');"></button>
                        </form>
                        <a href="<?= base_url('kategori/edit/' . $c['kd_kategori']); ?>" class="btn btn-sm btn-warning bi-pencil-fill"></a>
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