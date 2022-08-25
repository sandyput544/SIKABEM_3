<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<form action="/pengurus/event/save" method="POST" enctype="multipart/form-data">
  <?= csrf_field(); ?>
  <div class="row g-3">
    <div class="col-12 d-flex justify-content-between">
      <a href="/pengurus/event" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
      <button type="submit" class="btn btn-primary rounded-3"><i class="bi-cloud-upload-fill me-2"></i><span>Submit</span></button>
    </div>
    <div class="col-12">
      <div class="card text-dark mb-3 shadow rounded-3">
        <div class="card-header fw-bold d-flex justify-content-between">
          <span class="fs-5"><?= $curr_page; ?></span>

        </div>
        <div class="card-body">
          <div class="row g-3">
            <!-- <div class="col-6">
              <label for="inputTanggalMulai">Tanggal Mulai</label>
              <input type="text" class="form-control" id="inputTanggalMulai" name="start_date" value="<?= old('start_date'); ?>" autofocus>
              <?php if ($validation->hasError('start_date')) {
                echo '<small class="text-danger">' . $validation->getError('start_date') . '</small>';
              } ?>
            </div>
            <div class="col-6">
              <label for="inputTanggalSelesai">Tanggal Selesai</label>
              <input type="text" class="form-control" id="inputTanggalSelesai" name="end_date" value="<?= old('end_date'); ?>" autofocus>
              <?php if ($validation->hasError('end_date')) {
                echo '<small class="text-danger">' . $validation->getError('end_date') . '</small>';
              } ?>
            </div> -->
            <div class="col-12">
              <label for="inputEvent">Nama Event</label>
              <input type="text" class="form-control" id="inputEvent" name="event_name" value="<?= old('event_name'); ?>">
              <?php if ($validation->hasError('event_name')) {
                echo '<small class="text-danger">' . $validation->getError('event_name') . '</small>';
              } ?>
            </div>
            <div class="col-12">
              <?php helper('form'); ?>
              <label for="inputContent">Konten</label>
              <textarea id="editor" name="event_content"><?= old('event_content'); ?></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<?= $this->endSection(); ?>