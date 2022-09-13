<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12">
        <a href="<?= base_url('arsip'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
      </div>
      <div class="col-12">
        <form action="<?= base_url('arsip/update/' . $archives['kd_arsip']); ?>" method="POST" enctype="multipart/form-data">
          <?= csrf_field(); ?>
          <div class="card text-dark mb-3 shadow overflow-hidden rounded-4">
            <div class="card-header fw-bold fs-5"><?= $card; ?></div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <div class="row g-3">
                    <div class="col-6">
                      <label for="selectCategory" class="form-label">Pilih Kategori Arsip</label>
                      <select class="form-select" id="selectCategory" name="kd_kategori">
                        <?php foreach ($categories as $c) : ?>
                          <option value="<?= $c['kd_kategori']; ?>" <?= (old('kd_kategori', $c['kd_kategori']) == $archives['kd_kategori']) ? 'selected' : ''; ?>><?= $c['nama_kat']; ?></option>
                        <?php endforeach; ?>
                      </select>
                      <?= showError('kd_kategori'); ?>
                    </div>
                    <div class="col-6">
                      <label for="inputNo" class="form-label">Nomor Arsip</label>
                      <input type="text" class="form-control" id="inputNo" placeholder="003/SK/XI/2022" name="nomor_arsip" value="<?= old('nomor_arsip', $archives['nomor_arsip']); ?>">
                      <?= showError('nomor_arsip'); ?>
                    </div>
                    <div class="col-12">
                      <label for="inputName" class="form-label">Nama Arsip</label>
                      <input type="text" class="form-control" id="inputName" placeholder="Anggaran Dasar Aturan Rumah Tangga 2020" name="nama_arsip" value="<?= old('nama_arsip', $archives['nama_arsip']); ?>">
                      <?= showError('nama_arsip'); ?>
                    </div>
                    <div class="col-6">
                      <label for="inputDate" class="form-label">Tanggal Buat</label>
                      <input type="text" class="form-control" id="inputDate" name="tgl_buat" value="<?= old('tgl_buat', $archives['tgl_buat']); ?>">
                      <?= showError('tgl_buat'); ?>
                    </div>
                    <div class="col-6">
                      <label for="inputCreator" class="form-label">Nama Pembuat</label>
                      <input type="text" class="form-control" id="inputCreator" placeholder="Nama lengkap seseorang" name="nama_pembuat" value="<?= old('nama_pembuat', $archives['nama_pembuat']); ?>">
                      <?= showError('nama_pembuat'); ?>
                    </div>
                    <div class="col-12">
                      <label for="inputFile" class="form-label">Unggah File Arsip</label>
                      <input type="file" class="form-control" id="inputFile" name="file_arsip">
                      <?= showError('file_arsip'); ?>
                    </div>
                    <div class="col-12"><span>Jenis file yang ditangani : PDF</span></div>
                  </div>
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

<?= $this->endSection(); ?>