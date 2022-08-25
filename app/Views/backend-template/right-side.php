<div class="right-side">
  <nav class="top-nav bg-light d-flex flex-nowrap shadow border-bottom border-secondary bg-opacity-75">
    <button class="toggle-sidebar bg-dark-bem"><i class="bi-list"></i></button>
    <div class="w-100 d-flex justify-content-between align-items-center px-2">
      <span class="text-dark align-middle fw-bold text-uppercase"><?= $title; ?></span>
      <div class="d-flex justify-content-end align-items-center">
        <span class="text-dark me-3">
          <?= session('full_name'); ?>
        </span>
        <img src="<?= base_url('foto_profil/' . session('photo')); ?>" alt="" width="32" height="32" class="rounded-circle me-2" <?= (session('photo') == "default.svg") ? 'class="bg-light"' : ''; ?>>
      </div>
    </div>
  </nav>
  <div class="content container-fluid p-3">
    <?= $this->renderSection('content'); ?>
  </div>
</div>