<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="/pengurus/departemen" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-12">
    <form action="/pengurus/departemen/save" method="POST" enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <div class="card text-dark mb-3 shadow overflow-hidden rounded-3">
        <div class="card-header fw-bold fs-5"><?= $curr_page; ?></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-12 col-sm-7">
              <label for="inputName">Nama Departemen</label>
              <input type="text" class="form-control" id="inputName" name="dept_name" value="<?= old('dept_name'); ?>" autofocus>
              <?php if ($validation->hasError('dept_name')) {
                echo '<small class="text-danger">' . $validation->getError('dept_name') . '</small>';
              } ?>
            </div>
            <div class="col-12 col-sm">
              <label for="inputAcronim">Akronim</label>
              <input type="text" class="form-control" id="inputAcronim" name="dept_acronim" value="<?= old('dept_acronim'); ?>">
              <?php if ($validation->hasError('dept_acronim')) {
                echo '<small class="text-danger">' . $validation->getError('dept_acronim') . '</small>';
              } ?>
            </div>
            <div class="col-12 col-sm">
              <label for="selectDivision">Pilih Divisi</label>
              <select class="form-select" id="selectDivision" name="dept_level">
                <option value="First Division" <?= (old('dept_level')) ? 'selected' : 'selected'; ?>>Divisi Atas</option>
                <option value="Second Division" <?= (old('dept_level')) ? 'selected' : ''; ?>>Divisi Bawah</option>
              </select>
              <?php if ($validation->hasError('dept_level')) {
                echo '<small class="text-danger">' . $validation->getError('dept_level') . '</small>';
              } ?>
            </div>
            <div class="col-12">
              <label for="editor1">Deskripsi Departemen</label>
              <textarea type="text" class="form-control" rows="5" id="editor1" name="dept_desc"><?= old('dept_desc'); ?></textarea>
            </div>
            <div class="col-12 col-sm-6">
              <label for="inputLogoName">Nama Logo</label>
              <input type="text" class="form-control" id="inputLogoName" name="dept_logo_name" value="<?= old('dept_logo_name'); ?>">
            </div>
            <div class="col-12 col-sm-6">
              <label for="inputFileLogo">File Logo</label>
              <input type="file" class="form-control" id="inputFileLogo" name="dept_logo_file">
              <?php if ($validation->hasError('dept_logo_file')) {
                echo '<small class="text-danger">' . $validation->getError('dept_logo_file') . '</small>';
              } ?>
            </div>
            <div class="col-12">
              <label for="editor2">Deskripsi Logo Departemen</label>
              <textarea type="text" rows="5" id="editor2" name="dept_logo_desc"><?= old('dept_logo_desc'); ?></textarea>
            </div>
          </div>
        </div>
        <button class="btn btn-primary rounded-0" type="submit">Simpan</button>
      </div>
    </form>
  </div>

  <?= $this->endSection(); ?>