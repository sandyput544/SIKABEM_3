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
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= $card; ?>
            <a href="infoUserPos" class="bi bi-info-circle text-secondary" data-bs-toggle="modal" data-bs-target="#infoUserPos"></a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table align-middle">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Nama Arsip</th>
                    <th scope="col">Tanggal Update</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1;
                  foreach ($archives as $a) : ?>
                    <tr>
                      <th scope="row"><?= $i++; ?></th>
                      <td><?= $a['cat_name']; ?></td>
                      <td><?= $a['archive_name']; ?></td>
                      <td><?= $a['updated_at']; ?></td>
                      <td>
                        <form action="<?= base_url('arsip/hapus/' . $a['id']); ?>" class="d-inline" method="post">
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class="btn btn-sm btn-danger bi-trash3-fill" onclick="return confirm('Apakah anda yakin ingin menghapus <?= $a['archive_name']; ?>?');"></button>
                        </form>
                        <a href="<?= base_url('arsip/edit/' . $a['id']); ?>" class="btn btn-sm btn-warning bi-pencil-fill"></a>
                        <a href="<?= base_url('arsip/detail/' . $a['id']); ?>" class="btn btn-sm btn-info bi-eye-fill"></a>
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

<div class="modal fade" id="infoUserPos" tabindex="-1" aria-labelledby="infoUserPosModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoUserPosModal">Info Menu Terhapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-12">
            <<p>Keterangan tombol aksi :</p>
              <ol>
                <li><button class="btn btn-primary"><i class="bi-plus-lg me-2"></i><span>Tambah Data</span></button> untuk menambah anggota.</li>
                <li><button class="btn btn-secondary"><i class="bi-trash me-2"></i><span>Data Terhapus</span></button> untuk melihat menu yang terhapus.</li>
                <li><button class="btn btn-warning"><i class="bi-pencil-fill"></i></button> untuk memperbarui data salah satu menu.</li>
                <li><button class="btn btn-danger"><i class="bi-trash3-fill"></i></button> untuk menghapus data salah satu menu.</li>
              </ol>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Mengerti</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>