<?php helper('bem') ?>
<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12 mb-3">
    <a href="<?= base_url('/posisi'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-12">
    <div class="card text-dark shadow overflow-hidden rounded-3">
      <div class="card-header fw-bold fs-5 d-flex justify-content-between">
        <?= 'Tabel ' . $card; ?>
        <a href="infoUserRole" class="bi bi-info-circle text-secondary" data-bs-toggle="modal" data-bs-target="#infoUserRole"></a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Menu</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1;
              foreach ($menus as $m) : ?>
                <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $m['menu_name']; ?></td>
                  <td>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" <?= getPosAccess($pos_id, $m['id']); ?> data-position="<?= $pos_id; ?>" data-menu="<?= $m['id']; ?>">
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
    var menuId = $(this).data('menu');
    var posId = $(this).data('position');

    $.ajax({
      url: "<?= base_url('posisi/akses/grant'); ?>",
      method: 'POST',
      data: {
        menuId: menuId,
        posId: posId
      },
      success: function() {
        location.href = "<?= base_url('posisi/akses'); ?>/" + posId;
      }
    });
  });
</script>
<?= $this->endSection(); ?>