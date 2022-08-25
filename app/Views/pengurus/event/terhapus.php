<?php

use CodeIgniter\I18n\Time;
?>
<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12 d-flex justify-content-between">
    <a href="/pengurus/event" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
    <div>
      <form action="/pengurus/event/restoreAll" class="d-inline" method="post">
        <input type="hidden" name="_method" value="PUT">
        <button type="submit" class="btn btn-primary rounded-3" onclick="return confirm('Apakah anda ingin mengembalikan semua event yang terhapus?');"><i class="bi-arrow-counterclockwise me-2"></i><span>Kembalikan Semua Event</span></button>
      </form>
      <form action="/pengurus/event/permanently-delete" class="d-inline" method="post">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-danger rounded-3" onclick="return confirm('Apakah anda yakin ingin benar-benar menghapus semua event yang terhapus secara permanen?');"><i class="bi-trash3-fill me-2"></i><span>Hapus Permanen</span></button>
      </form>
    </div>
  </div>
  <div class="col-12">
    <div class="card text-dark shadow overflow-hidden rounded-3">
      <div class="card-header fw-bold fs-5 d-flex justify-content-between">
        <?= 'Tabel ' . $curr_page; ?>
        <a href="infoDeletedEvent" class="bi bi-info-circle text-secondary" data-bs-toggle="modal" data-bs-target="#infoDeletedEvent">
        </a>
      </div>
      <div class="card-body row g-3">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Judul</th>
                <th scope="col">Terhapus</th>
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
                  <td><?= Time::parse($e['deleted_at'])->toLocalizedString('MMMM, d YYYY'); ?></td>
                  <td><?= $e['event_status']; ?></td>
                  <td>
                    <form action="/pengurus/event/restore/<?= $e['event_id']; ?>" class="d-inline" method="post">
                      <input type="hidden" name="_method" value="PUT">
                      <button type="submit" class="btn btn-sm btn-primary bi-arrow-counterclockwise" onclick="return confirm('Apakah anda ingin mengembalikan <?= $e['event_name']; ?>?');"></button>
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

<div class="modal fade" id="infoDeletedEvent" tabindex="-1" aria-labelledby="infoDeletedEventModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoDeletedEventModal">Info Event Terhapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-12">
            <p>Cara mengembalikan event yang sudah terhapus :</p>
            <ol>
              <li><button class="btn btn-primary"><i class="bi-arrow-counterclockwise me-2"></i><span>Kembalikan Semua Anggota</span></button> untuk mengembalikan semua event yang terhapus.</li>
              <li><button class="btn btn-primary bi-arrow-counterclockwise"></button> untuk mengembalikan event satu-persatu</li>
            </ol>
            <p>Cara menghapus secara permanen dari tabel event yaitu dengan mengklik tombol <button class="btn btn-danger"><i class="bi-trash3-fill me-2"></i><span>Hapus Permanen</span></button></p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Mengerti</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>