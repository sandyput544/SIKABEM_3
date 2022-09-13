<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="<?= base_url('jenis-surat'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-6">
    <form action="<?= base_url('jenis-surat/update/' . $mt['kd_jenissurat']); ?>" method="POST">
      <?= csrf_field(); ?>
      <div class="card text-dark mb-3 shadow overflow-hidden rounded-4">
        <div class="card-header fw-bold fs-5"><?= $card; ?></div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="row g-3">
                <div class="col-12">
                  <label for="inputName" class="form-label">Nama Jenis Surat</label>
                  <input type="text" class="form-control" id="inputName" placeholder="Surat Keputusan" name="nama_jenis" value="<?= old('nama_jenis', $mt['nama_jenis']); ?>" autofocus>
                  <?= showError('nama_jenis'); ?>
                </div>
                <div class="col-12">
                  <label for="inputCode" class="form-label">Kode Surat</label>
                  <input type="text" class="form-control" id="inputCode" placeholder="SK" name="kode_surat" value="<?= old('kode_surat', $mt['kode_surat']); ?>">
                  <?= showError('kode_surat'); ?>
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

<?= $this->endSection(); ?>