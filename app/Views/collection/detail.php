<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="<?= base_url('koleksi'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
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
                  <td><?= $archives['nama_arsip']; ?></td>
                </tr>
                <tr>
                  <td>Jenis Arsip</td>
                  <td>:</td>
                  <td><?= $archives['kategori']; ?></td>
                </tr>
                <tr>
                  <td>Nomor Arsip</td>
                  <td>:</td>
                  <td><?= $archives['nomor_arsip']; ?></td>
                </tr>
                <tr>
                  <td>Pembuat Arsip</td>
                  <td>:</td>
                  <td><?= $archives['pembuat']; ?></td>
                </tr>
                <tr>
                  <td>Tanggal Buat</td>
                  <td>:</td>
                  <td><?= $archives['tgl_buat']; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6 col-sm-12">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>Ukuran File</td>
                  <td>:</td>
                  <td><?= $archives['ukuran_file']; ?> Mb</td>
                </tr>
                <tr>
                  <td>MIME Type</td>
                  <td>:</td>
                  <td><?= $archives['mime']; ?></td>
                </tr>
                <tr>
                  <td>Tanggal Upload</td>
                  <td>:</td>
                  <td><?= $archives['pertama_up']; ?></td>
                </tr>
                <tr>
                  <td>Tanggal Diperbarui</td>
                  <td>:</td>
                  <td><?= $archives['tgl_modif']; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-12 d-flex justify-content-end">
            <a href="<?= base_url('koleksi/download/' . $archives['nama_file']); ?>" class="btn btn-secondary rounded-3"><i class="bi-download me-2"></i><span>Download File</span></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12">
    <div class="card text-dark mb-3 shadow overflow-hidden rounded-3">
      <div class="card-header fw-bold fs-5">Preview File</div>
      <div class="card-body">
        <iframe src="<?= base_url('archives/' . $archives['nama_file']); ?>" width="100%" height="500px"></iframe>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>