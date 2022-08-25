<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="/pengurus/event" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-12">
    <h3><?= $event['event_name']; ?></h3>
    <hr>
    <div>
      <?= $event['event_content']; ?>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>