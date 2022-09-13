<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="<?= base_url('arsip'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-12">
    <div class="card text-dark shadow overflow-hidden rounded-4">
      <div class="card-header fw-bold fs-5">
        <?= $accessing; ?>
      </div>
      <div class="card-body">
        <table id="access" class="table align-middle table-striped">
          <thead>
            <tr>
              <th scope="col">Nama User</th>
              <th scope="col">Jabatan</th>
              <th scope="col">Tanggal Akses</th>
              <th scope="col">Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($list_access as $a) : ?>
              <tr>
                <td><?= $a['nama_user']; ?></td>
                <td><?= $a['singkatan_jbt']; ?></td>
                <td><?= $a['tgl_akses']; ?></td>
                <td><?= $a['keterangan']; ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-12">
    <div class="card text-dark mb-3 shadow overflow-hidden rounded-4">
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
                <tr>
                  <td>Nama Uploader</td>
                  <td>:</td>
                  <td><?= $archives['nama_uploader']; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12">
    <div class="card text-dark mb-3 shadow overflow-hidden rounded-4">
      <div class="card-header fw-bold fs-5">Preview File</div>
      <div class="card-body">
        <iframe src="<?= base_url('archives/' . $archives['nama_file']); ?>" width="100%" height="500px"></iframe>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
  $(document).ready(function() {
    $('#access').DataTable({
      
    });
  });
</script>
<?= $this->endSection(); ?>