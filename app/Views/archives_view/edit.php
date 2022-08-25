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
      <div class="col-6">
        <form action="<?= base_url('arsip/update/' . $archives['id']); ?>" method="POST" enctype="multipart/form-data">
          <?= csrf_field(); ?>
          <div class="card text-dark mb-3 shadow overflow-hidden rounded-3">
            <div class="card-header fw-bold fs-5"><?= $card; ?></div>
            <div class="card-body">
              <div class="row">
                <div class="col-12">
                  <div class="row g-3">
                    <div class="col-12">
                      <label for="inputName">Nama Arsip</label>
                      <input type="text" class="form-control" id="inputName" placeholder="Anggaran Dasar Aturan Rumah Tangga 2020" name="archive_name" value="<?= old('archive_name', $archives['archive_name']); ?>" autofocus>
                      <?= showError('archive_name'); ?>
                    </div>
                    <div class="col-12">
                      <label for="selectCategory">Pilih Kategori Arsip</label>
                      <select class="form-select" id="selectCategory" name="cat_id">
                        <?php foreach ($categories as $c) : ?>
                          <option value="<?= $c['id']; ?>" <?= (old('cat_id', $c['id']) == $archives['cat_id']) ? 'selected' : ''; ?>><?= $c['cat_name']; ?></option>
                        <?php endforeach; ?>
                      </select>
                      <?= showError('cat_id'); ?>
                    </div>
                    <div class="col-12">
                      <label for="inputFile">Unggah File Arsip</label>
                      <input type="file" class="form-control" id="inputFile" name="archive_file">
                      <?= showError('archive_file') ?>
                    </div>
                    <div class=" col-12"><span>Jenis file yang ditangani : PDF</span>
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
  </div>
</div>

<?= $this->endSection(); ?>