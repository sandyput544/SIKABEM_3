<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="/pengurus/kritik-saran" class="btn btn-outline-secondary"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-12">
    <form action="/pengurus/kritik-saran/save" method="POST" enctype="multipart/form-data">
      <div class="card text-dark mb-3 shadow rounded-4 overflow-hidden">
        <div class="card-header fw-bold d-flex justify-content-between">
          <span class="fs-5"><?= $curr_page; ?></span>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-12">
              <label for="inputNama">Nama Pengirim</label>
              <input type="text" class="form-control <?= ($validation->hasError('sender_name')) ? 'is-invalid' : ''; ?>" id="inputNama" name="sender_name" value="<?= old('sender_name'); ?>" autofocus>
              <div class="invalid-feedback">
                <?= $validation->getError('sender_name'); ?>
              </div>
            </div>
            <div class="col-12">
              <label for="inputEmail">Email Pengirim</label>
              <input type="text" class="form-control <?= ($validation->hasError('sender_email')) ? 'is-invalid' : ''; ?>" id="inputEmail" name="sender_email" value="<?= old('sender_email'); ?>">
              <div class="invalid-feedback">
                <?= $validation->getError('sender_email'); ?>
              </div>
            </div>
            <div class="col-12">
              <label for="inputSubjek">Subjek</label>
              <input type="text" class="form-control <?= ($validation->hasError('sender_subject')) ? 'is-invalid' : ''; ?>" id="inputSubjek" name="sender_subject" value="<?= old('sender_subject'); ?>" autofocus>
              <div class="invalid-feedback">
                <?= $validation->getError('sender_subject'); ?>
              </div>
            </div>
            <div class="col-12">
              <?php helper('form'); ?>
              <label for="sender_content">Kritik dan Saran</label>
              <textarea id="editor" name="sender_content"><?= old('sender_content'); ?></textarea>
            </div>
            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Hide" name="hide_name" id="checkHideName">
                <label class="form-check-label" for="checkHideName">
                  Sembunyikan Nama
                </label>
              </div>
            </div>
          </div>
        </div>
        <button class="btn btn-primary rounded-0 border-0" type="submit">Simpan</button>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection(); ?>