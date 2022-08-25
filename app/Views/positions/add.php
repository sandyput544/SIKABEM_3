<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="<?= base_url('posisi'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-6">
    <form action="<?= base_url('posisi/save'); ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <div class="card text-dark mb-3 shadow overflow-hidden rounded-3">
        <div class="card-header fw-bold fs-5"><?= $card; ?></div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="row g-3">
                <div class="col-12">
                  <label for="inputName">Nama Posisi</label>
                  <input type="text" class="form-control" id="inputName" placeholder="Pembina/Ketua" name="pos_name" value="<?= old('pos_name'); ?>" autofocus>
                  <?= showError('pos_name'); ?>
                </div>
                <div class="col-12">
                  <input class="form-check-input" type="checkbox" value="1" id="flexCheckIsActive" name="is_active">
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