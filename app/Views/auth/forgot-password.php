<?= $this->extend('\backend-template\auth'); ?>
<?= $this->section('content'); ?>
<div class="row d-flex justify-content-center align-items-center h-100">
  <div class="col-lg-4">
    <form action="<?= base_url() ?>/auth/forgot" method="post">
      <?= csrf_field(); ?>
      <div class="card rounded-4 overflow-hidden shadow">
        <?= csrf_field(); ?>
        <div class="card-body">
          <h4 class="card-title text-center fw-bold mb-3">Lupa Password</h4>
          <div class="row">
            <?php if (session()->getFlashdata('pesan')) : ?>
              <?= session()->getFlashdata('pesan'); ?>
            <?php endif; ?>
            <div class="col-12">
              <div class="row g-3">
                <div class="col-12">
                  <label for="emailInput" class="form-label">Email</label>
                  <input type="email" class="form-control rounded-pill" id="emailInput" placeholder="name@example.com" name="email" value="<?= old('email'); ?>" autocomplete="off" autofocus required>
                </div>
                <div class="col-12 mt-4">
                  <a href="/auth" class="text-decoration-underline">Sudah memiliki akun?</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary rounded-0">Submit</button>
      </div>
    </form>
  </div>
</div>
</div>
<?= $this->endSection(); ?>