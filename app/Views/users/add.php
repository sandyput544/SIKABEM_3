<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="<?= base_url('/user'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-6">
    <form action="<?= base_url('/user/save'); ?>" method="POST">
      <?= csrf_field(); ?>
      <div class="card text-dark mb-3 shadow overflow-hidden rounded-3">
        <div class="card-header fw-bold fs-5">
          <?= $card; ?>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-12">
              <label for="fullname">Nama Lengkap</label>
              <input type="text" name="full_name" placeholder="Contoh: Armand Maumandi" id="full_name" class="form-control" value="<?= old('full_name'); ?>">
              <?= showError('full_name'); ?>
            </div>
            <div class="col-12">
              <label for="selectPosition">Pilih Posisi Jabatan</label>
              <select class="form-select" id="selectPosition" name="pos_id">
                <option value="0" selected>Pilih Posisi</option>
                <?php foreach ($positions as $p) : ?>
                  <option value="<?= $p['id']; ?>" <?php (old('pos_id', $p['id'])) ? 'selected' : ''; ?>><?= $p['pos_name']; ?></option>
                <?php endforeach; ?>
              </select>
              <?= showError('pos_id'); ?>
            </div>
            <div class="col-12">
              <label for="jk" class="form-label">Jenis Kelamin</label>
              <div id="jk">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="Pria" checked>
                  <label class="form-check-label" for="inlineRadio1">Pria</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="Wanita">
                  <label class="form-check-label" for="inlineRadio2">Wanita</label>
                </div>
              </div>
            </div>
            <div class="col-12">
              <label for="phoneInput">Nomor Ponsel</label>
              <input type="text" name="phone" placeholder="Contoh: 081215633425" id="phoneInput" class="form-control" value="<?= old('phone'); ?>">
              <?= showError('phone') ?>
            </div>
            <div class="col-12">
              <label for="emailInput">Email</label>
              <input type="text" name="email" placeholder="Contoh: seseorang@mail.com" id="emailInput" class="form-control" value="<?= old('email'); ?>">
              <?= showError('email') ?>
            </div>
            <div class="col-12">
              <label for="password1Input">Password</label>
              <input type="password" name="password1" id="password1Input" class="form-control" value="<?= old('password'); ?>">
              <?= showError('password1') ?>
            </div>
            <div class="col-12">
              <label for="password2Input">Konfirmasi Password</label>
              <input type="password" name="password2" id="password2Input" class="form-control">
              <?= showError('password2'); ?>
            </div>
          </div>
        </div>
        <button class="btn btn-primary rounded-0" type="submit">Simpan</button>
      </div>
    </form>
  </div>
</div>

<?= $this->endsection(); ?>