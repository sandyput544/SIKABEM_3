<?php

use CodeIgniter\I18n\Time;
?>
<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="/pengurus/artikel" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-12">
    <h3 class="fw-bold"><?= $article['judul']; ?></h3>
    <p class="text-muted"><?= Time::parse($article['updated_at'])->toLocalizedString('MMMM d, yyyy'); ?> by <?= $article['nama_lengkap']; ?></p>
    <hr>
    <img src="/assets/img/article_banner/<?= $article['article_banner']; ?>" alt="" class="article_banner mb-3">
    <div>
      <?= $article['article_content']; ?>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>