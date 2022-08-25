<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <div class="col-12">
    <form action="/pengurus/anggota/update/<?= $members['member_id']; ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <div class="card text-dark mb-3 shadow overflow-hidden rounded-3">
        <div class="card-header fw-bold fs-5"><?= $form_profil; ?></div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="alert alert-primary" role="alert">
                <i class="bi-info-circle-fill flex-shrink-0 me-2"></i>
                Password yang tampil saat ini adalah password yang sudah terenkripsi. Jika tidak ingin mengganti password, kolom isian password bisa dibiarkan.
              </div>
            </div>
            <div class="col-12">
              <div class="alert alert-primary" role="alert">
                <i class="bi-info-circle-fill flex-shrink-0 me-2"></i>
                Jika tidak ingin mengganti posisi jabatan <?= $members['nama_lengkap']; ?>, kolom pilih posisi bisa dibiarkan.
              </div>
            </div>
            <div classs="col-12">
              <div class="row g-3">
                <div class="col-12 col-sm-6">
                  <label for="npmInput">NPM</label>
                  <input type="text" name="npm" id="npmInput" placeholder="Contoh: 160302031" class="form-control" value="<?= old('npm', $members['npm']); ?>">
                  <?php if ($validation->hasError('npm')) {
                    echo '<small class="text-danger">' . $validation->getError('npm') . '</small>';
                  } ?>
                </div>
                <div class="col-12 col-sm-6">
                  <label for="fullnameInput">Nama Lengkap</label>
                  <input type="text" name="nama_lengkap" placeholder="Contoh: Armand Maumandi" id="fullnameInput" class="form-control" value="<?= old('nama_lengkap', $members['nama_lengkap']); ?>">
                  <?php if ($validation->hasError('nama_lengkap')) {
                    echo '<small class="text-danger">' . $validation->getError('nama_lengkap') . '</small>';
                  } ?>
                </div>
                <div class="col-12 col-sm-6">
                  <label for="emailInput">Email</label>
                  <input type="text" name="email" placeholder="Contoh: mymail@mail.com" id="emailInput" class="form-control" value="<?= old('email', $members['email']); ?>">
                  <?php if ($validation->hasError('email')) {
                    echo '<small class="text-danger">' . $validation->getError('email') . '</small>';
                  } ?>
                </div>
                <div class="col-12 col-sm-6">
                  <label for="passwordInput">Password</label>
                  <input type="text" name="password" id="passwordInput" class="form-control" value="<?= old('password', $members['password']); ?>">
                  <?php if ($validation->hasError('password')) {
                    echo '<small class="text-danger">' . $validation->getError('password') . '</small>';
                  } ?>
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

<?= $this->endsection(); ?>