<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-4">
  <div class="col-12">
    <a href="/pengurus/departemen" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-12">
    <form action="/pengurus/departemen/update-data/<?= $departments['dept_id']; ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <div class="card text-dark shadow overflow-hidden rounded-3">
        <div class="card-header fw-bold fs-5"><?= $form_edit_dept; ?></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-12 col-sm-7">
              <label for="inputName">Nama Departemen</label>
              <input type="text" class="form-control" id="inputName" name="dept_name" value="<?= old('dept_name', $departments['dept_name']); ?>" autofocus>
              <?php if ($validation->hasError('dept_name')) {
                echo '<small class="text-danger">' . $validation->getError('dept_name') . '</small>';
              } ?>
            </div>
            <div class="col-12 col-sm">
              <label for="inputAcronim">Akronim</label>
              <input type="text" class="form-control" id="inputAcronim" name="dept_acronim" value="<?= old('dept_acronim', $departments['dept_acronim']); ?>">
              <?php if ($validation->hasError('dept_acronim')) {
                echo '<small class="text-danger">' . $validation->getError('dept_acronim') . '</small>';
              } ?>
            </div>
            <div class="col-12 col-sm">
              <label for="selectDivision">Pilih Divisi</label>
              <select class="form-select" id="selectDivision" name="dept_level">
                <option value="First Division" <?php (old('dept_level', $departments['dept_level']) == "First Division") ? 'selected' : ''; ?>>Divisi Atas</option>
                <option value="Second Division" <?= (old('dept_level', $departments['dept_level']) == "Second Division") ? 'selected' : ''; ?>>Divisi Bawah</option>
              </select>
              <?php if ($validation->hasError('dept_level')) {
                echo '<small class="text-danger">' . $validation->getError('dept_level') . '</small>';
              } ?>
            </div>
            <div class="col-12">
              <label for="editor1">Deskripsi Departemen</label>
              <textarea type="text" class="form-control" rows="5" id="editor1" name="dept_desc"><?= old('dept_desc', $departments['dept_desc']); ?></textarea>
            </div>
          </div>
        </div>
        <button class="btn btn-primary rounded-0">Simpan Data Departemen</button>
      </div>
    </form>
  </div>
  <div class="col-12 col-sm-3">
    <div class="row">
      <div class="col-12 mb-4">
        <div class="card shadow overflow-hidden rounded-3">
          <div class="card-header fw-bold fs-5">Preview Logo</div>
          <div class="card-body">
            <img src="/assets/img/dept_logo_img/<?= $departments['dept_logo_file']; ?>" alt="" class="card-img-preview">
          </div>
        </div>
      </div>
      <div class="col-12">
        <form action="/pengurus/departemen/delete-image/<?= $departments['dept_id']; ?>" method="POST" class="d-grid">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger" <?= ($departments['dept_logo_file'] == 'default_logo.svg') ? 'disabled' : ''; ?> onclick="return confirm('Apakah anda yakin ingin menghapus logo <?= $departments['dept_name']; ?>?');">
            <i class="bi-trash3-fill"></i>
            <span>Hapus Logo</span>
          </button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-9 flex-grow-1">
    <form action="/pengurus/departemen/update-image/<?= $departments['dept_id']; ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <div class="card text-dark shadow overflow-hidden rounded-3">
        <div class="card-header fw-bold fs-5"><?= $form_edit_logo; ?></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-12">
              <label for="inputLogoName">Nama Logo</label>
              <input type="text" class="form-control" id="inputLogoName" name="dept_logo_name" value="<?= old('dept_logo_name', $departments['dept_logo_name']); ?>">
            </div>
            <div class="col-12">
              <label for="inputFileLogo">File Logo</label>
              <input type="file" class="form-control" id="inputFileLogo" name="dept_logo_file" onchange="cardLogoPreview();">
              <?php if ($validation->hasError('dept_logo_file')) {
                echo '<small class="text-danger">' . $validation->getError('dept_logo_file') . '</small>';
              } ?>
            </div>
            <div class="col-12">
              <label for="editor2">Deskripsi Logo Departemen</label>
              <textarea type="text" class="form-control" rows="5" id="editor2" name="dept_logo_desc"><?= old('dept_logo_desc', $departments['dept_logo_desc']); ?></textarea>
            </div>
          </div>
        </div>
        <button class="btn btn-primary rounded-0">Simpan Logo Departemen</button>
      </div>
    </form>
  </div>

  <?= $this->endSection(); ?>