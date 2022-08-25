<?php

use CodeIgniter\I18n\Time;
?>
<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row g-3">
  <div class="col-12 d-flex justify-content-between">
    <a href="/pengurus/artikel" class="btn btn-secondary rounded-3"><i class="bi-arrow-left me-2"></i><span>Kembali</span></a>
    <div>
      <form action="/pengurus/artikel/restoreAll" class="d-inline" method="post">
        <input type="hidden" name="_method" value="PUT">
        <button type="submit" class="btn btn-primary rounded-3" onclick="return confirm('Apakah anda ingin mengembalikan semua artikel yang terhapus?');"><i class="bi-arrow-counterclockwise me-2"></i><span>Kembalikan Semua Anggota</span></button>
      </form>
      <form action="/pengurus/artikel/permanently-delete" class="d-inline" method="post">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-danger rounded-3" onclick="return confirm('Apakah anda yakin ingin benar-benar menghapus artikel secara permanen?');"><i class="bi-trash3-fill me-2"></i><span>Hapus Permanen</span></button>
      </form>
    </div>
  </div>
  <div class="col-12">
    <div class="card text-dark shadow overflow-hidden rounded-3">
      <div class="card-header fw-bold fs-5 d-flex justify-content-between">
        <?= 'Tabel ' . $curr_page; ?>
        <a href="infoDeletedArticle" class="bi bi-info-circle text-secondary" data-bs-toggle="modal" data-bs-target="#infoDeletedArticle">
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
              foreach ($articles as $a) : ?>
                <tr>
                  <th scope="row"><?= $i++; ?></th>
                  <td><?= $a['judul']; ?></td>
                  <td><?= Time::parse($a['deleted_at'])->toLocalizedString('MMMM, d YYYY'); ?></td>
                  <td><?= $a['article_status']; ?></td>
                  <td>
                    <form action="/pengurus/artikel/restore/<?= $a['article_id']; ?>" class="d-inline" method="post">
                      <input type="hidden" name="_method" value="PUT">
                      <button type="submit" class="btn btn-sm btn-primary bi-arrow-counterclockwise" onclick="return confirm('Apakah anda ingin mengembalikan <?= $a['judul']; ?>?');"></button>
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

<div class="modal fade" id="infoDeletedArticle" tabindex="-1" aria-labelledby="infoDeletedArticleModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoDeletedArticleModal">Info Artikel Terhapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-12">
            <p>Cara mengembalikan artikel yang sudah terhapus :</p>
            <ol>
              <li><button class="btn btn-primary"><i class="bi-arrow-counterclockwise me-2"></i><span>Kembalikan Semua Anggota</span></button> untuk mengembalikan semua artikel yang terhapus.</li>
              <li><button class="btn btn-primary bi-arrow-counterclockwise"></button> untuk mengembalikan artikel satu-persatu</li>
            </ol>
            <p>Cara menghapus secara permanen dari tabel artikel yaitu dengan mengklik tombol <button class="btn btn-danger"><i class="bi-trash3-fill me-2"></i><span>Hapus Permanen</span></button></p>
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