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
      <div class="col-12 d-flex justify-content-end">
        <div>
          <a href="<?= base_url() . '/pengurus/event/buat'; ?>" class="btn btn-primary rounded-3"><i class="bi-plus-lg"></i><span>Buat Event</span></a>
          <a href="<?= base_url() . '/pengurus/event/terhapus'; ?>" class="btn btn-secondary rounded-3"><i class="bi-trash3-fill me-2"></i><span>Data Terhapus</span></a>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= 'Tabel ' . $curr_page; ?>
          </div>
          <div class="card-body row g-3">
            <div class="table-responsive">
              <table class="table align-middle">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Event</th>
                    <!-- <th scope="col">Tanggal</th> -->
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  foreach ($events as $e) : ?>
                    <tr>
                      <th scope="row"><?= $i++; ?></th>
                      <td><?= $e['event_name']; ?></td>
                      <!-- <td><?php // Time::parse($e['start_date'])->toLocalizedString('d, MMMM YYYY'); 
                                ?></td> -->
                      <td><span class="badge <?= ($e['event_status'] == "Open") ? "text-bg-primary" : "text-bg-secondary" ?>"><?= $e['event_status']; ?></span></td>
                      <td>
                        <a href="/pengurus/event/preview/<?= $e['event_slug']; ?>" class="btn btn-sm btn-info bi-eye-fill"></a>
                        <a href="/pengurus/event/edit/<?= $e['event_slug']; ?>" class="btn btn-sm btn-warning bi-pencil-fill"></a>
                        <form action="/pengurus/event/<?= $e['event_id']; ?>" class="d-inline" method="post">
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class="btn btn-sm btn-danger bi-trash3-fill" onclick="return confirm('Apakah anda yakin ingin menghapus <?= $e['event_name']; ?>?');"></button>
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