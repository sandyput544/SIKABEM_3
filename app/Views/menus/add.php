<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="<?= site_url('menu'); ?>" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-6">
    <form action="<?= site_url('menu/save'); ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <div class="card text-dark mb-3 shadow overflow-hidden rounded-4">
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
                  <input type="text" class="form-control" id="inputMenu" placeholder="Menu atau Dashboard" name="nama_menu" value="<?= old('nama_menu'); ?>" autofocus>
                  <?= showError('nama_menu'); ?>
                </div>
                <div class="col-12">
                  <label for="inputUrl">URL</label>
                  <input type="text" class="form-control" id="inputUrl" placeholder="menu atau kritik-saran" name="url_menu" value="<?= old('url_menu'); ?>">
                  <?= showError('url_menu'); ?>
                </div>
                <div class="col-12">
                  <label for="inputIcon">Nama Icon</label>
                  <input type="text" class="form-control" id="inputIcon" placeholder="bi-diagram-3-fill" name="ikon_menu" value="<?= old('ikon_menu'); ?>">
                  <?= showError('ikon_menu'); ?>
                </div>
                <div class="col-12">
                  <input class="form-check-input" type="checkbox" value="1" id="flexCheckIsActive" name="menu_active">
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