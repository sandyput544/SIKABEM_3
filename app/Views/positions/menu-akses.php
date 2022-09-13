<?php helper('bem') ?>
<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12 mb-3">
    <a href="<?= base_url('/jabatan'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-6">
    <div class="card text-dark shadow overflow-hidden rounded-4">
      <div class="card-header fw-bold fs-5">
        <?= $card; ?>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th scope="col">Nama Menu</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($menus as $m) : ?>
                <tr>
                  <td><?= $m['nama_menu']; ?></td>
                  <td>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" <?= getPosAccess($kd_jabatan, $m['kd_menu']); ?> data-position="<?= $kd_jabatan; ?>" data-menu="<?= $m['kd_menu']; ?>">
                    </div>
                  </td>
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
<script type="text/javascript">
  $('.form-check-input').on('click', function() {
    var kd_menu = $(this).data('menu');
    var kd_jabatan = $(this).data('position');

    $.ajax({
      url: "<?= base_url('jabatan/akses/grant'); ?>",
      method: 'POST',
      data: {
        kd_menu: kd_menu,
        kd_jabatan: kd_jabatan
      },
      success: function() {
        location.href = "<?= base_url('jabatan/akses'); ?>/" + kd_jabatan;
      }
    });
  });
</script>
<?= $this->endSection(); ?>