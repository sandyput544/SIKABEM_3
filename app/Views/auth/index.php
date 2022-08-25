<?= $this->extend('\backend-template\auth'); ?>
<?= $this->section('content'); ?>
<div class="row d-flex justify-content-center align-items-center h-100">
  <div class="col-8">
    <div class="row d-flex justify-content-center">
      <div class="col-12">
        <h1 class="text-orange-bem text-center py-5" style="margin-top: -200px;">Selamat Datang di SIBEM PNC</h1>
      </div>
      <div class="col-6">
        <form action="<?= base_url() ?>/auth/login" method="post">
          <div class="card rounded-4 overflow-hidden shadow">
            <?= csrf_field(); ?>
            <div class="card-body">
              <h4 class="card-title text-center fw-bold mb-3">Login SIBEM</h4>
              <div class="row">
                <?php if (session()->getFlashdata('pesan')) : ?>
                  <?= session()->getFlashdata('pesan'); ?>
                <?php endif; ?>
                <div class="col-12">
                  <div class="row g-3">
                    <div class="col-12">
                      <label for="emailInput" class="form-label">Email</label>
                      <input type="email" class="form-control rounded-pill" id="emailInput" placeholder="name@example.com" name="email" value="<?= old('email'); ?>" autofocus>
                      <?php if ($validation->hasError('email')) {
                        echo '<small class="text-danger">' . $validation->getError('email') . '</small>';
                      } ?>
                    </div>
                    <div class="col-12">
                      <label for="passwordInput" class="form-label">Password</label>
                      <input type="password" class="form-control rounded-pill" id="passwordInput" name="password" value="" autocomplete="off">
                      <?php if ($validation->hasError('password')) {
                        echo '<small class="text-danger">' . $validation->getError('password') . '</small>';
                      } ?>
                    </div>
                    <!-- <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="checkRemember">
                        <label class="form-check-label" for="checkRemember">
                          Remember me!
                        </label>
                      </div>
                    </div>
                    <div class="col-12 mt-4">
                      <a href="/auth/lupa-password" class="text-decoration-underline">Apakah anda lupa password?</a>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-orange-bem rounded-0 fw-bold">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>