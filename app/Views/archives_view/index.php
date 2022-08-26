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
          <a href="<?= base_url('arsip/tambah'); ?>" class="btn btn-primary rounded-3"><i class="bi-plus-lg me-2"></i><span>Tambah Posisi</span></a>
          <a href="<?= base_url('arsip/terhapus'); ?>" class="btn btn-danger rounded-3"><i class="bi-trash3-fill me-2"></i><span>Posisi Terhapus</span></a>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-3">
          <div class="card-header fw-bold fs-5">
            <?= $card; ?>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table align-middle">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Nama Arsip</th>
                    <th scope="col">Tahun Buat</th>
                    <th scope="col">Nama Pembuat</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1;
                  foreach ($archives as $a) : ?>
                    <tr>
                      <th scope="row"><?= $i++; ?></th>
                      <td><?= $a['nama_kat']; ?></td>
                      <td><?= $a['nama_arsip']; ?></td>
                      <td><?= $a['tgl_buat']; ?></td>
                      <td><?= $a['nama_pembuat']; ?></td>
                      <td>
                        <form action="<?= base_url('arsip/hapus/' . $a['kd_arsip']); ?>" class="d-inline" method="post">
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class="btn btn-sm btn-danger bi-trash3-fill" onclick="return confirm('Apakah anda yakin ingin menghapus <?= $a['nama_arsip']; ?>?');"></button>
                        </form>
                        <a href="<?= base_url('arsip/edit/' . $a['kd_arsip']); ?>" class="btn btn-sm btn-warning bi-pencil-fill"></a>
                        <a href="<?= base_url('arsip/detail/' . $a['kd_arsip']); ?>" class="btn btn-sm btn-info bi-eye-fill"></a>
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