<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>
<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-6">
            <div class="fw-bold fs-5"><?= $card; ?></div>
          </div>
          <div class="col-6 d-flex justify-content-end">
            <div>
              <a href="<?= base_url('profil/edit'); ?>" class="btn btn-sm btn-warning rounded-3"><i class="bi-pencil-fill me-2"></i><span>Edit Profil</span></a>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-3">
            <img src="<?= base_url('/foto_profil/' . $user['photo']); ?>" alt="" class="rounded-circle show-profpic mb-3">
            <h4 class="text-center"><?= $user['pos_name']; ?></h4>
          </div>
          <div class="col-9">
            <div class="row g-3">
              <div class="col-12">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input class="form-control" type="text" value="<?= $user['full_name']; ?>" id="nama_lengkap" readonly>
              </div>
              <div class="col-12 col-sm-6">
                <label for="tmp_lahir" class="form-label">Tempat Lahir</label>
                <input class="form-control" type="text" value="<?= $user['birthplace']; ?>" id="tmp_lahir" readonly>
              </div>
              <div class="col-12 col-sm-6">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input class="form-control" type="text" value="<?= $user['birthdate']; ?>" id="tgl_lahir" readonly>
              </div>
              <div class="col-12 col-sm-6">
                <label for="agama" class="form-label">Agama</label>
                <input class="form-control" type="text" value="<?= $user['religion']; ?>" id="agama" readonly>
              </div>
              <div class="col-12 col-sm-6">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <input class="form-control" type="text" value="<?= $user['gender']; ?>" id="jenis_kelamin" readonly>
              </div>
              <div class="col-12">
                <label for="nomor_ponsel" class="form-label">Nomor Ponsel</label>
                <input class="form-control" type="text" value="<?= $user['phone']; ?>" id="nomor_ponsel" readonly>
              </div>
              <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input class="form-control" type="text" value="<?= $user['email']; ?>" id="email" readonly>
              </div>
              <div class="col-12">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" type="text" id="alamat" readonly><?= $user['address']; ?></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endsection(); ?>