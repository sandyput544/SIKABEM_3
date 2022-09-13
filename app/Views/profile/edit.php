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
      <div class="col-12 col-sm-6">
        <form action="<?= base_url('/profil/ganti_foto'); ?>" method="POST" enctype="multipart/form-data">
          <?= csrf_field(); ?>
          <div class="card text-dark mb-3 shadow overflow-hidden rounded-4">
            <div class="card-header fw-bold fs-5">Form Ganti Foto</div>
            <div class="card-body">
              <div class="row g-3 d-flex">
                <div class="col-12">
                  <img src="/assets/foto_profil/<?= $user['foto']; ?>" alt="" class="img-preview me-auto ms-auto">
                  <label for="foto" class="form-label">Pilih File Foto</label>
                  <input type="file" class="form-control" id="foto" name="foto" onchange="imgPreview();">
                  <?= showError('foto'); ?>
                </div>
              </div>
            </div>
            <button class="btn btn-primary rounded-0" type="submit">Simpan</button>
          </div>
        </form>
        <form action="<?= base_url('/profil/hapus_foto'); ?>" method="POST" class="d-grid">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus foto profil anda?');" <?= ($user['foto'] == 'default.svg' || $user['foto'] == null) ? 'disabled' : ''; ?>>
            <i class="bi-trash3-fill"></i>
            <span>Hapus Foto</span>
          </button>
        </form>
      </div>
      <div class="col-12 col-sm-6">
        <div class="row g-3">
          <div class="col-12">
            <form action="<?= base_url('/profil/edit_profil'); ?>" method="POST">
              <?= csrf_field(); ?>
              <div class="card text-dark mb-3 shadow overflow-hidden rounded-4">
                <div class="card-header fw-bold fs-5">Form Edit Profil</div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-12">
                      <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                      <input class="form-control" type="text" name="nama_user" value="<?= old('nama_user', $user['nama_user']); ?>" id="nama_lengkap" <?= showError('nama_user'); ?>>
                    </div>
                    <div class="col-12 col-sm-6">
                      <label for="tmp_lahir" class="form-label">Tempat Lahir</label>
                      <input class="form-control" type="text" name="tmp_lahir" value="<?= old('tmp_lahir', $user['tmp_lahir']); ?>" id="tmp_lahir">
                      <?= showError('tmp_lahir'); ?>
                    </div>
                    <div class="col-12 col-sm-6">
                      <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                      <input class="form-control" type="text" name="tgl_lahir" value="<?= old('tgl_lahir', $user['tgl_lahir']); ?>" id="tgl_lahir">
                      <?= showError('tgl_lahir'); ?>
                    </div>
                    <div class="col-12 col-sm-6">
                      <label for="agama" class="form-label">Agama</label>
                      <select class="form-select" id="agama" name="agama">
                        <option value="0">Pilih Agama</option>
                        <?php foreach ($agama as $a) : ?>
                          <option value="<?= $a; ?>" <?= (old('agama', $user['agama']) == $a) ? "selected" : ""; ?>><?= $a; ?></option>
                        <?php endforeach; ?>
                      </select>
                      <?= showError('agama'); ?>
                    </div>
                    <div class="col-12 col-sm-6">
                      <label for="jk" class="form-label">Jenis Kelamin</label>
                      <div id="jk" class="d-flex py-2">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="jk" id="inlineRadio1" value="Pria" <?= checked($user['jk'], 'Pria'); ?>>
                          <label class="form-check-label" for="inlineRadio1">Pria</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="jk" id="inlineRadio2" value="Wanita" <?= checked($user['jk'], 'Wanita'); ?>>
                          <label class="form-check-label" for="inlineRadio2">Wanita</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <label for="nomor_ponsel" class="form-label">Nomor Ponsel</label>
                      <input class="form-control" type="text" value="<?= old('no_hp', $user['no_hp']); ?>" id="nomor_ponsel" name="no_hp">
                      <?= showError('no_hp'); ?>
                    </div>
                    <div class="col-12">
                      <label for="email" class="form-label">Email</label>
                      <input class="form-control" type="email" value="<?= old('email', $user['email']); ?>" id="email" name="email">
                      <?= showError('email'); ?>
                    </div>
                    <div class="col-12">
                      <label for="alamat" class="form-label">Alamat</label>
                      <textarea class="form-control" name="alamat" type="text" id="alamat"><?= old('alamat', $user['alamat']); ?></textarea>
                    </div>
                  </div>
                </div>
                <button class="btn btn-primary rounded-0" type="submit">Simpan</button>
              </div>
            </form>
          </div>
          <div class="col-12">
            <form action="<?= base_url('/profil/ganti_password'); ?>" method="POST">
              <?= csrf_field(); ?>
              <div class="card text-dark mb-3 shadow overflow-hidden rounded-4">
                <div class="card-header fw-bold fs-5">Form Ganti Password</div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-12 col-sm-6">
                      <label for="password1" class="form-label">Password Baru</label>
                      <input class="form-control" type="password" name="password1" id="password1">
                      <?= showError('password1'); ?>
                    </div>
                    <div class="col-12 col-sm-6">
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