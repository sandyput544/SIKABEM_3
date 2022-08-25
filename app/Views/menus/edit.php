<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="<?= base_url('menu'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-6">
    <form action="<?= base_url('menu/update/' . $menus['id']); ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <div class="card text-dark mb-3 shadow overflow-hidden rounded-3">
        <div class="card-header fw-bold fs-5"><?= $card; ?></div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="alert alert-primary" role="alert">
                <i class="bi-info-circle-fill flex-shrink-0 me-2"></i>
                <a href="https://icons.getbootstrap.com/">Pilih icon disini</a> kemudian salin dan tempelkan di kolom isian icon.
              </div>
            </div>
            <div class="col-12">
              <div class="row g-3">
                <div class="col-12">
                  <label for="inputMenu">Nama Menu</label>
                  <input type="text" class="form-control" id="inputMenu" placeholder="Menu atau Dashboard" name="menu_name" value="<?= old('menu_name', $menus['menu_name']); ?>" autofocus>
                  <?= showError('menu_name'); ?>
                </div>
                <div class="col-12">
                  <label for="inputUrl">URL</label>
                  <input type="text" class="form-control" id="inputUrl" placeholder="menu atau kritik-saran" name="menu_url" value="<?= old('menu_url', $menus['menu_url']); ?>">
                  <?= showError('menu_url'); ?>
                </div>
                <div class="col-12">
                  <label for="inputIcon">Nama Icon</label>
                  <input type="text" class="form-control" id="inputIcon" placeholder="bi-diagram-3-fill" name="menu_icon" value="<?= old('menu_icon', $menus['menu_icon']); ?>">
                  <?= showError('menu_icon'); ?>
                </div>
                <div class="col-12">
                  <input class="form-check-input" type="checkbox" value="1" id="flexCheckIsActive" name="is_active" <?= checked($menus['is_active'], 1); ?>>
                  <label class="form-check-label" for="flexCheckIsActive">
                    Aktifkan
                  </label>
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

<?= $this->endSection(); ?>