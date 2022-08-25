<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3 d-flex">
  <div class="col-12">
    <a href="/pengurus/level-anggota" class="btn btn-secondary"><i class="bi-arrow-left"></i><span>Kembali</span></a>
  </div>
  <div class="col-12 col-sm-6 align-items-center">
    <form action="/pengurus/level-anggota/update-data/<?= $member_levels['memberlevel_id']; ?>" method="POST">
      <?= csrf_field(); ?>
      <div class="card text-dark mb-3 shadow overflow-hidden rounded-4">
        <div class="card-header fw-bold fs-5"><?= $form; ?></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <input type="hidden" name="memberlevel_id" value="<?= $member_levels['memberlevel_id']; ?>">
              <label for="selectDept">Pilih Divisi</label>
              <select class="form-select" id="selectDept" name="dept_id">
                <option value="0" selected>Pilih Divisi</option>
                <?php foreach ($departments as $d) : ?>
                  <option value="<?= $d['dept_id']; ?>" <?= (old('dept_id', $d['dept_id']) && $d['dept_id'] == $member_levels['dept_id']) ? 'selected' : ''; ?>><?= $d['dept_name']; ?></option>
                <?php endforeach; ?>
              </select>
              <?php if ($validation->hasError('dept_id')) {
                echo '<small class="text-danger">' . $validation->getError('dept_id') . '</small>';
              } ?>
            </div>
            <div class="col-12 col-md-6">
              <label for="inputMemberLevelSeats">Jumlah Kursi Level</label>
              <input type="text" class="form-control" id="inputMemberLevelSeats" name="memberlevel_seats" value="<?= old('memberlevel_seats', $member_levels['memberlevel_seats']); ?>">
              <?php if ($validation->hasError('memberlevel_seats')) {
                echo '<small class="text-danger">' . $validation->getError('memberlevel_seats') . '</small>';
              } ?>
            </div>
            <div class="col-12">
              <label for="inputMemberLevel">Nama Level Anggota</label>
              <input type="text" class="form-control" id="inputMemberLevel" name="memberlevel_name" value="<?= old('memberlevel_name', $member_levels['memberlevel_name']); ?>">
              <?php if ($validation->hasError('memberlevel_name')) {
                echo '<small class="text-danger">' . $validation->getError('memberlevel_name') . '</small>';
              } ?>
            </div>
          </div>
        </div>
        <button class="btn btn-primary rounded-0">Simpan</button>
      </div>
    </form>
  </div>

  <?= $this->endSection(); ?>