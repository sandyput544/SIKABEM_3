<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <!-- Card Rekap Total -->
  <div class="col-12 col-sm-3">
    <div class="card text-white bg-danger shadow overflow-hidden rounded-4">
      <div class="card-body">
        <h2><?= $totalMail; ?><i class="bi-send ms-2"></i></h2>
        <span>Surat Keluar</span>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-3">
    <div class="card text-white bg-blue-bem shadow overflow-hidden rounded-4">
      <div class="card-body">
        <h2><?= $totalArc; ?><i class="bi-archive ms-2"></i></h2>
        <span>Total Arsip</span>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-3">
    <div class="card text-white bg-success shadow overflow-hidden rounded-4">
      <div class="card-body">
        <h2><?= $totalUser; ?><i class="bi-people ms-2"></i></h2>
        <span>Total User</span>
      </div>
    </div>
  </div>
  <div class="col-12 col-sm-3 mb-3">
    <div class="card text-white bg-secondary shadow overflow-hidden rounded-4">
      <div class="card-body">
        <h2><?= $totalNonActive; ?><i class="bi-people ms-2"></i></h2>
        <span>Total User Nonaktif</span>
      </div>
    </div>
  </div>
  <hr>
  <div class="col-12 mb-3">
    <div class="card text-dark shadow overflow-hidden rounded-4">
      <div class="card-header fw-bold fs-5 d-flex justify-content-between">
        <?= $card1; ?>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="arsip" class="table align-middle table-striped">
            <thead>
              <tr>
                <th scope="col">Nama Arsip</th>
                <th scope="col">Nomor Arsip</th>
                <th scope="col">Upload</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($archives as $a) : ?>
                <tr>
                  <td><?= $a['nama_arsip']; ?></td>
                  <td><?= $a['nomor_arsip']; ?></td>
                  <td><?= $a['tgl_update']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="col-12">
    <div class="card text-dark shadow overflow-hidden rounded-4">
      <div class="card-header fw-bold fs-5 d-flex justify-content-between">
        <?= $card2; ?>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="users" class="table align-middle table-striped">
            <thead>
              <tr>
                <th scope="col">Nama User</th>
                <th scope="col">Jabatan</th>
                <th scope="col">Status</th>
                <th scope="col">Tanggal Login</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($users as $u) : ?>
                <tr>
                  <td><?= $u['nama_user']; ?></td>
                  <td><?= ($u['id_jbt'] == 0) ? "-" : $u['jabatan']; ?></td>
                  <td><span class="badge <?= ($u['is_login'] == "1") ? "bg-info text-white" : ""; ?>">
                      <?= ($u['is_login'] == "1") ? "Aktif" : ""; ?></span></td>
                  <td><?= $u['log_date']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
  $(document).ready(function() {
    $('#arsip').DataTable({
      order: [
        [1, 'desc']
      ],
    });
    $('#users').DataTable({
      order: [
        [2, 'desc']
      ],
    });
  });
</script>
<?= $this->endSection(); ?>