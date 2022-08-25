<?php

use CodeIgniter\I18n\Time;
?>
<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12">
    <a href="/pengurus/kritik-saran" class="btn btn-outline-secondary"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
  </div>
  <div class="col-12">
    <form action="/pengurus/kritik-saran/replying/<?= $critic['critic_id']; ?>" method="POST" enctype="multipart/form-data">
      <div class="card text-dark mb-3 shadow rounded-4 overflow-hidden">
        <div class="card-header fw-bold d-flex justify-content-between">
          <span class="fs-5"><?= $curr_page; ?></span>
          <div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="Hide" name="hide_critic" id="checkHideCritic">
              <label class="form-check-label" for="checkHideCritic">
                Sembunyikan Konten
              </label>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <h5 class="fw-bold"><?= $critic['sender_subject']; ?></h5>
              <small>Dari : <?= $critic['sender_name']; ?></small><br>
              <small class="text-muted"><?= Time::parse($critic['created_at'])->toLocalizedString('MMM d, yyyy'); ?></small>
              <div>
                <?= $critic['sender_content']; ?>
              </div>
            </div>
            <hr class="mb-3">
            <div class="col-12">
              <div class="row g-3">
                <div class="col-12">
                  <label for="inputReplyer">Nama Pembalas</label>
                  <input type="text" class="form-control <?= ($validation->hasError('replyer_name')) ? 'is-invalid' : ''; ?>" id="inputReplyer" name="replyer_name" value="<?= old('replyer_name', $critic['replyer_name']); ?>">
                  <div class="invalid-feedback">
                    <?= $validation->getError('replyer_name'); ?>
                  </div>
                </div>
                <div class="col-12">
                  <label for="inputContent">Konten</label>
                  <textarea id="editor" name="reply_content"><?= old('reply_content', $critic['reply_content']); ?></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary rounded-0 border-0"><i class="bi bi-reply-fill"></i><span>Balas</span></button>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection(); ?>