<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="<?= base_url('arsip'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-12">
    <div class="card text-dark mb-3 shadow overflow-hidden rounded-3">
      <div class="card-header fw-bold fs-5"><?= $card; ?></div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>Nama Arsip</td>
                  <td>:</td>
                  <td><?= $archives['archive_name']; ?></td>
                </tr>
                <tr>
                  <td>Jenis Arsip</td>
                  <td>:</td>
                  <td><?= $cat_name; ?></td>
                </tr>
                <tr>
                  <td>Ukuran File</td>
                  <td>:</td>
                  <td><?= $archives['file_size']; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6 col-sm-12">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>MIME Type</td>
                  <td>:</td>
                  <td><?= $archives['mime_type']; ?></td>
                </tr>
                <tr>
                  <td>Ekstensi</td>
                  <td>:</td>
                  <td><?= $archives['file_ext']; ?></td>
                </tr>
                <tr>
                  <td>Tanggal Diperbarui</td>
                  <td>:</td>
                  <td><?= $archives['updated_at']; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12">
    <div class="card text-dark mb-3 shadow overflow-hidden rounded-3">
      <div class="card-header fw-bold fs-5">Preview File</div>
      <div class="card-body">
        <iframe src="<?= base_url('archives/' . $archives['file_name']); ?>" width="100%" height="500px"></iframe>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>