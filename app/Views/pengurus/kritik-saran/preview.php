<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <div class="col-12">
    <h3><?= $event['event_name']; ?></h3>
    <small>Penulis : <?= $event['penulis']; ?></small>
    <div>
      <?= $event['event_content']; ?>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>