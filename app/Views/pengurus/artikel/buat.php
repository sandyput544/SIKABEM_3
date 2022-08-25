<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<form action="/pengurus/artikel/save" method="POST" enctype="multipart/form-data">
  <?= csrf_field(); ?>
  <div class="row g-3">
    <div class="col-12 d-flex justify-content-between">
      <a href="/pengurus/artikel" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
      <div>
        <button type="submit" class="btn btn-warning" name="article_status" value="Draft"><i class="bi-device-ssd-fill me-2"></i><span>Draft</span></button>
        <button type="submit" class="btn btn-primary" name="article_status" value="Publish"><i class="bi-cloud-upload-fill me-2"></i><span>Publish</span></button>
      </div>
    </div>
    <div class="col-12">
      <div class="card text-dark mb-3 shadow rounded-4">
        <div class="card-header fw-bold d-flex justify-content-between">
          <span class="fs-5"><?= $curr_page; ?></span>
        </div>
        <div class="card-body">
          <div class="row">
            <?php
            if (session()->getFlashdata('pesan')) :
              echo session()->getFlashdata('pesan');
            endif; ?>
            <div class="col-12">
              <div class="row g-3">
                <div class="col-12">
                  <label for="inputJudul">Judul Artikel</label>
                  <input type="text" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>" id="inputJudul" name="judul" value="<?= old('judul'); ?>">
                  <?php if ($validation->hasError('judul')) {
                    echo '<small class="text-danger">' . $validation->getError('judul') . '</small>';
                  } ?>
                </div>
                <div class="col-12">
                  <label for="inputArticleBanner">Foto Banner Anggota</label>
                  <input type="file" class="form-control" id="inputArticleBanner" name="article_banner">
                  <?php if ($validation->hasError('article_banner')) {
                    echo '<small class="text-danger">' . $validation->getError('article_banner') . '</small>';
                  } ?>
                </div>
                <div class="col-12">
                  <?php helper('form'); ?>
                  <label for="inputContent">Konten</label>
                  <textarea id="editor" name="article_content"><?= set_value('article_content'); ?></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script type="text/javascript">
  ClassicEditor
    .create(document.querySelector('#editor'), {
      toolbar: {
        ui: {
          viewportOffset: {
            top: 50
          }
        },
        shouldNotGroupWhenFull: true,
      },
      removePlugins: ['Title']
    });
</script>
<?= $this->endSection(); ?>