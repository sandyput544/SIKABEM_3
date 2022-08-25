<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="<?= base_url('kategori'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-6">
    <form action="<?= base_url('kategori/update/' . $category['kd_kategori']); ?>" method="POST">
      <?= csrf_field(); ?>
      <div class="card text-dark mb-3 shadow overflow-hidden rounded-3">
        <div class="card-header fw-bold fs-5"><?= $card; ?></div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="row g-3">
                <div class="col-12">
                  <label for="inputName">Nama Kategori</label>
                  <input type="text" class="form-control" id="inputName" placeholder="Laporan Pertanggungjawaban" name="nama_kat" value="<?= old('nama_kat', $category['nama_kat']); ?>" autofocus>
                  <?= showError('nama_kat'); ?>
                </div>
                <div class="col-12">
                  <label for="inputAcronim">Singkatan Nama Kategori</label>
                  <input type="text" class="form-control" id="inputAcronim" placeholder="Laporan Pertanggungjawaban" name="singkatan_kat" value="<?= old('singkatan_kat', $category['singkatan_kat']); ?>" autofocus>
                  <?= showError('singkatan_kat'); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-primary rounded-0" type="submit">Simpan</button>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection(); ?>