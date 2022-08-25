<?php helper('bem') ?>
<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <div class="col-12 mb-3">
    <a href="/pengurus/level-anggota" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <?php if (session()->getFlashdata('pesan')) : ?>
    <div class="col-12">
      <div class="alert alert-success d-flex align-items-center alert-dismissible" role="alert">
        <i class="bi-check-circle-fill flex-shrink-0 me-2"></i>
        <?= session()->getFlashdata('pesan'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  <?php endif; ?>
  <div class="col-12">
    <div class="card text-dark shadow overflow-hidden rounded-3">
      <div class="card-header fw-bold fs-5 d-flex justify-content-between">
        <?= 'Tabel ' . $curr_page; ?>
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
              foreach ($user_menus as $m) : ?>
                <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $m['title']; ?></td>
                  <td>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" <?= checked_level_access($level_id, $m['umaccess_id']); ?> data-level="<?= $level_id; ?>" data-menu="<?= $m['umaccess_id']; ?>">
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
    var umaccessId = $(this).data('menu');
    var levelId = $(this).data('level');

    $.ajax({
      url: "<?= base_url('/pengurus/level-anggota/level-akses/edit-akses'); ?>",
      method: 'POST',
      data: {
        umaccessId: umaccessId,
        levelId: levelId
      },
      success: function() {
        location.href = "<?= base_url(); ?>/pengurus/level-anggota/level-akses/" + levelId;
      }
    });
  });
</script>
<?= $this->endSection(); ?>