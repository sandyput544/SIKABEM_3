<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>
<div class="row g-3">
  <div class="col-12">
    <a href="<?= base_url('user'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-header fw-bold fs-5"><?= $card; ?></div>
      <div class="card-body">
        <div class="row">
          <div class="col-3">
            <img src="<?= base_url('/foto_profil/' . $user['foto']); ?>" alt="" class="rounded-circle show-profpic mb-3">
            <h4 class="text-center"><?= $user['singkatan_jbt']; ?></h4>
          </div>
          <div class="col-9">
            <div class="row g-3">
              <div class="col-12">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input class="form-control" type="text" value="<?= $user['nama_user']; ?>" id="nama_lengkap" readonly>
              </div>
              <div class="col-12 col-sm-6">
                <label for="tmp_lahir" class="form-label">Tempat Lahir</label>
                <input class="form-control" type="text" value="<?= $user['tmp_lahir']; ?>" id="tmp_lahir" readonly>
              </div>
              <div class="col-12 col-sm-6">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input class="form-control" type="text" value="<?= $user['tgl_lahir']; ?>" id="tgl_lahir" readonly>
              </div>
              <div class="col-12 col-sm-6">
                <label for="agama" class="form-label">Agama</label>
                <input class="form-control" type="text" value="<?= $user['agama']; ?>" id="agama" readonly>
              </div>
              <div class="col-12 col-sm-6">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <input class="form-control" type="text" value="<?= $user['jk']; ?>" id="jenis_kelamin" readonly>
              </div>
              <div class="col-12">
                <label for="nomor_ponsel" class="form-label">Nomor Ponsel</label>
                <input class="form-control" type="text" value="<?= $user['no_hp']; ?>" id="nomor_ponsel" readonly>
              </div>
              <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input class="form-control" type="text" value="<?= $user['email']; ?>" id="email" readonly>
              </div>
              <div class="col-12">
                <label for="password" class="form-label">Email</label>
                <input class="form-control" type="text" value="<?= $user['password']; ?>" id="password" readonly>
              </div>
              <div class="col-12">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" type="text" id="alamat" readonly><?= $user['alamat']; ?></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endsection(); ?>