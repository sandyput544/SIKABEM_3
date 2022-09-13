<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="<?= base_url('surat-keluar'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-12 col-md-9">
    <form action="<?= base_url('surat-keluar/create'); ?>" method="POST">
      <?= csrf_field(); ?>
      <div class="card text-dark mb-3 shadow overflow-hidden rounded-4">
        <div class="card-header fw-bold fs-5">Buat Surat Keluar</div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-12 col-sm-6">
              <label for="selectMailType" class="form-label">Pilih Jenis Surat Keluar</label>
              <select class="form-select" id="selectMailType" name="kd_jenissurat">
                <?php foreach ($mailtype as $mt) : ?>
                  <option value="<?= $mt['kd_jenissurat']; ?>" <?= (old('kd_jenissurat') == $mt['kd_jenissurat']) ? 'selected' : ''; ?>><?= $mt['nama_jenis']; ?></option>
                <?php endforeach; ?>
              </select>
              <?= showError('kd_jenissurat'); ?>
            </div>
            <div class="col-12 col-sm-4">
              <label for="inputNumber" class="form-label">Nomor Surat</label>
              <input type="text" class="form-control" id="inputNumber" placeholder="Contoh : 001/BEM/VIII/2020" name="nomor_surat" value="<?= old('nomor_surat'); ?>">
              <?= showError('nomor_surat'); ?>
            </div>
            <div class="col-12 col-sm-2">
              <label for="inputLampiran" class="form-label">Lampiran</label>
              <input type="text" class="form-control" id="inputLampiran" placeholder="Contoh : 1" name="lampiran" value="<?= old('lampiran'); ?>">
              <?= showError('lampiran'); ?>
            </div>
            <div class="col-12">
              <label for="inputPerihal" class="form-label">Perihal</label>
              <input type="text" class="form-control" id="inputPerihal" placeholder="Contoh : Rapat Pembahasan Acara Kaderisasi" name="perihal" value="<?= old('perihal'); ?>">
              <?= showError('perihal'); ?>
            </div>
            <div class="col-6">
              <label for="inputTglbuat" class="form-label">Tanggal Buat</label>
              <input type="text" class="form-control" id="inputTglbuat" name="tgl_buat" value="<?= old('tgl_buat'); ?>">
              <?= showError('tgl_buat'); ?>
            </div>
            <div class="col-6">
              <label for="inputTglTTD" class="form-label">Tanggal Ditandatangani</label>
              <input type="text" class="form-control" id="inputTglTTD" name="tgl_ttd" value="<?= old('tgl_ttd'); ?>">
              <?= showError('tgl_ttd'); ?>
            </div>
          </div>
        </div>
        <button class="btn btn-primary rounded-0" type="submit">Simpan</button>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection(); ?>