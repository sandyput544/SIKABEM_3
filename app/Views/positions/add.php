<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="<?= base_url('jabatan'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-6">
    <form action="<?= base_url('jabatan/save'); ?>" method="POST">
      <?= csrf_field(); ?>
      <div class="card text-dark mb-3 shadow overflow-hidden rounded-4">
        <div class="card-header fw-bold fs-5"><?= $card; ?></div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="row g-3">
                <div class="col-12">
                  <label for="inputName" class="form-label">Nama Jabatan</label>
                  <input type="text" class="form-control" id="inputName" placeholder="Departemen Komunikasi dan Informasi" name="nama_jbt" value="<?= old('nama_jbt'); ?>" autofocus>
                  <?= showError('nama_jbt'); ?>
                </div>
                <div class="col-6">
                  <label for="inputAcronim" class="form-label">Singkatan Jabatan</label>
                  <input type="text" class="form-control" id="inputAcronim" placeholder="Dept. Kominfo" name="singkatan_jbt" value="<?= old('singkatan_jbt'); ?>">
                  <?= showError('singkatan_jbt'); ?>
                </div>
                <div class="col-6">
                  <label for="inputSeats" class="form-label">Jumlah Kursi</label>
                  <input type="text" class="form-control" id="inputSeats" placeholder="10" name="jml_kursi" value="<?= old('jml_kursi'); ?>">
                  <?= showError('jml_kursi'); ?>
                </div>
                <div class="col-12">
                  <input class="form-check-input" type="checkbox" value="1" id="flexCheckIsActive" name="jbt_active">
                  <label class="form-check-label" for="flexCheckIsActive">
                    Aktifkan
                  </label>
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