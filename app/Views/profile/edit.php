<?php
$agama = ['Buddha', 'Hindhu', 'Islam', 'Katholik', 'Konghucu', 'Kristen'];
?>
<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12">
        <a href="<?= base_url('/profil'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
      </div>
      <div class="col-12 col-sm-6">
        <form action="<?= base_url('/profil/edit_profil'); ?>" method="POST">
          <?= csrf_field(); ?>
          <div class="card text-dark mb-3 shadow overflow-hidden rounded-3">
            <div class="card-header fw-bold fs-5">Form Edit Profil</div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-12">
                  <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                  <input class="form-control" type="text" name="full_name" value="<?= old('full_name', $user['full_name']); ?>" id="nama_lengkap" <?= showError('full_name'); ?>>
                </div>
                <div class="col-12 col-sm-6">
                  <label for="tmp_lahir" class="form-label">Tempat Lahir</label>
                  <input class="form-control" type="text" name="birthplace" value="<?= old('birthplace', $user['birthplace']); ?>" id="tmp_lahir">
                  <?= showError('birthplace'); ?>
                </div>
                <div class="col-12 col-sm-6">
                  <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                  <input class="form-control" type="text" name="birthdate" placeholder="27-12-2000" value="<?= old('birtdate', $user['birthdate']); ?>" id="tgl_lahir">
                  <?= showError('birthdate'); ?>
                </div>
                <div class="col-12 col-sm-6">
                  <label for="agama" class="form-label">Agama</label>
                  <select class="form-select" id="agama" name="religion">
                    <option value="0">Pilih Agama</option>
                    <?php foreach ($agama as $a) : ?>
                      <option value="<?= $a; ?>" <?= (old('religion', $user['religion']) == $a) ? "selected" : ""; ?>><?= $a; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= showError('religion'); ?>
                </div>
                <div class="col-12 col-sm-6">
                  <label for="jk" class="form-label">Jenis Kelamin</label>
                  <div id="jk" class="d-flex py-2">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="Pria" <?= checked($user['gender'], 'Pria'); ?>>
                      <label class="form-check-label" for="inlineRadio1">Pria</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="Wanita" <?= checked($user['gender'], 'Wanita'); ?>>
                      <label class="form-check-label" for="inlineRadio2">Wanita</label>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <label for="nomor_ponsel" class="form-label">Nomor Ponsel</label>
                  <input class="form-control" type="text" value="<?= old('phone', $user['phone']); ?>" id="nomor_ponsel" name="phone">
                  <?= showError('phone'); ?>
                </div>
                <div class="col-12">
                  <label for="email" class="form-label">Email</label>
                  <input class="form-control" type="email" value="<?= old('email', $user['email']); ?>" id="email" name="email">
                  <?= showError('email'); ?>
                </div>
                <div class="col-12">
                  <label for="alamat" class="form-label">Alamat</label>
                  <textarea class="form-control" name="address" type="text" id="alamat"><?= old('address', $user['address']); ?></textarea>
                </div>
              </div>
            </div>
            <button class="btn btn-primary rounded-0" type="submit">Simpan</button>
          </div>
        </form>
      </div>
      <div class="col-12 col-sm-6">
        <div class="row g-3">
          <div class="col-12">
            <form action="<?= base_url('/profil/ganti_foto'); ?>" method="POST" enctype="multipart/form-data">
              <?= csrf_field(); ?>
              <div class="card text-dark mb-3 shadow overflow-hidden rounded-3">
                <div class="card-header fw-bold fs-5">Form Ganti Foto</div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-12">
                      <label for="photo" class="form-label">Pilih File Foto</label>
                      <input type="file" class="form-control" id="photo" name="photo">
                      <?= showError('photo'); ?>
                    </div>
                  </div>
                </div>
                <button class="btn btn-primary rounded-0" type="submit">Simpan</button>
              </div>
            </form>
            <form action="<?= base_url('/profil/hapus_foto'); ?>" method="POST" class="d-grid">
              <input type="hidden" name="_method" value="DELETE">
              <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus foto profil anda?');" <?= ($user['photo'] == 'default.svg' || $user['photo'] == null) ? 'disabled' : ''; ?>>
                <i class="bi-trash3-fill"></i>
                <span>Hapus Foto</span>
              </button>
            </form>
          </div>
          <div class="col-12">
            <form action="<?= base_url('/profil/ganti_password'); ?>" method="POST">
              <?= csrf_field(); ?>
              <div class="card text-dark mb-3 shadow overflow-hidden rounded-3">
                <div class="card-header fw-bold fs-5">Form Ganti Password</div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-12">
                      <label for="password1" class="form-label">Password Baru</label>
                      <input class="form-control" type="password" name="password1" id="password1">
                      <?= showError('password1'); ?>
                    </div>
                    <div class="col-12">
                      <label for="password2" class="form-label">Konfirmasi Password Baru</label>
                      <input class="form-control" type="password" name="password2" id="password2">
                      <?= showError('password2'); ?>
                    </div>
                  </div>
                </div>
                <button class="btn btn-primary rounded-0" type="submit">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endsection(); ?>