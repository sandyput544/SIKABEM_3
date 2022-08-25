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
              <label for="nama_user">Nama Lengkap</label>
              <input type="text" name="nama_user" placeholder="Contoh: Armand Maumandi" id="nama_user" class="form-control" value="<?= old('nama_user'); ?>">
              <?= showError('nama_user'); ?>
            </div>
            <div class="col-12">
              <label for="selectPosition">Pilih Jabatan</label>
              <select class="form-select" id="selectPosition" name="kd_jabatan">
                <option value="0" selected>Pilih Posisi</option>
                <?php foreach ($positions as $p) : ?>
                  <option value="<?= $p['kd_jabatan']; ?>" <?php (old('kd_jabatan', $p['kd_jabatan'])) ? 'selected' : ''; ?>><?= $p['nama_jbt']; ?></option>
                <?php endforeach; ?>
              </select>
              <?= showError('kd_jabatan'); ?>
            </div>
            <div class="col-12">
              <label for="jk" class="form-label">Jenis Kelamin</label>
              <div id="jk">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="jk" id="inlineRadio1" value="Pria" checked>
                  <label class="form-check-label" for="inlineRadio1">Pria</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="jk" id="inlineRadio2" value="Wanita">
                  <label class="form-check-label" for="inlineRadio2">Wanita</label>
                </div>
              </div>
            </div>
            <div class="col-12">
              <label for="phoneInput">Nomor Ponsel</label>
              <input type="text" name="no_hp" placeholder="Contoh: 081215633425" id="phoneInput" class="form-control" value="<?= old('no_hp'); ?>">
              <?= showError('no_hp') ?>
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