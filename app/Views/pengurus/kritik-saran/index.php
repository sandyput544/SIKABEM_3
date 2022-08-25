<?php

use CodeIgniter\I18n\Time;
?>
<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <div class="col-12">
      <div class="alert alert-success d-flex align-items-center alert-dismissible col-12" role="alert">
        <i class="bi-check-circle-fill flex-shrink-0 me-2"></i>
        <?= session()->getFlashdata('pesan'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= 'Tabel ' . $curr_page; ?>
            <a href="<?= base_url() . '/pengurus/kritik-saran/buat'; ?>" class="btn btn-primary btn-sm rounded-3"><i class="bi-plus-lg"></i></a>
          </div>
          <div class="card-body row g-3">
            <div class="table-responsive">
              <table class="table align-middle">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Pengirim</th>
                    <th scope="col">Subjek</th>
                    <th scope="col">Tanggal Kirim</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($critics as $c => $key) : ?>
                    <tr>
                      <th scope="row"><?= $c + 1; ?></th>
                      <td><?= $key['sender_name']; ?></td>
                      <td><?= $key['sender_subject']; ?></td>
                      <td><?= Time::parse($key['updated_at'])->humanize(); ?></td>
                      <td><span class="badge <?= ($key['status'] == "Replied") ? "text-bg-primary" : "text-bg-secondary" ?>"><?= $key['status']; ?></span></td>
                      <td>
                        <a href="/pengurus/kritik-saran/reply/<?= $key['critic_id']; ?>" class="btn btn-sm btn-info bi-reply-fill"></a>
                        <form action="/pengurus/kritik-saran/<?= $key['critic_id']; ?>" class="d-inline" method="post">
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class="btn btn-sm btn-danger bi-trash3-fill" onclick="return confirm('Apakah anda yakin ingin menghapus <?= $key['sender_subject']; ?>?');"></button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>