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
      <div class="col-12 d-flex justify-content-between">
        <a href="/pengurus/kategori-artikel" class="btn btn-secondary rounded-3"><i class="bi-tags-fill me-2"></i><span>Kategori Artikel</span></a>
        <div>
          <a href="<?= base_url() . '/pengurus/artikel/buat'; ?>" class="btn btn-primary rounded-3"><i class="bi-plus-lg"></i><span>Buat Artikel</span></a>
          <a href="<?= base_url() . '/pengurus/artikel/terhapus'; ?>" class="btn btn-secondary rounded-3"><i class="bi-trash3-fill me-2"></i><span>Data Terhapus</span></a>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= 'Tabel ' . $curr_page; ?>
            <a href="infoArticle" class="bi bi-info-circle text-secondary" data-bs-toggle="modal" data-bs-target="#infoArticle"></a>
          </div>
          <div class="card-body row g-3">
            <div class="table-responsive">
              <table class="table align-middle">
                <thead class="table-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Penulis</th>
                    <th scope="col">Judul Artikel</th>
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
                      <td><?= $a['nama_lengkap']; ?></td>
                      <td><?= $a['judul']; ?></td>
                      <td><span class="badge <?= ($a['article_status'] == "Publish") ? "text-bg-success" : "text-bg-warning" ?>"><?= $a['article_status']; ?></span></td>
                      <td class="d-flex justify-content-center">
                        <a href="/pengurus/artikel/preview/<?= $a['article_slug']; ?>" class="btn btn-sm btn-info bi-eye-fill"></a>
                        <?php if ($a['member_id'] == session()->get('member_id')) : ?>
                          <a href="/pengurus/artikel/edit/<?= $a['article_slug']; ?>" class="btn btn-sm btn-warning bi-pencil-fill"></a>
                          <form action="/pengurus/artikel/<?= $a['article_id']; ?>" class="d-inline" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger bi-trash3-fill" onclick="return confirm('Apakah anda yakin ingin menghapus <?= $a['judul']; ?>?');"></button>
                          </form>
                        <?php endif; ?>
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

<div class="modal fade" id="infoArticle" tabindex="-1" aria-labelledby="infoArticleModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoArticleModal">Info Departemen Terhapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-12">
            <p>Keterangan tombol aksi :</p>
            <ol>
              <li><button class="btn btn-primary"><i class="bi-plus-lg me-2"></i><span>Buat Artikel</span></button> untuk membuat artikel baru.</li>
              <li><button class="btn btn-secondary"><i class="bi-trash me-2"></i><span>Data Terhapus</span></button> untuk melihat artikel yang terhapus.</li>
              <li><button class="btn btn-info"><i class="bi-eye-fill"></i></button> untuk melihat preview artikel.</li>
              <li><button class="btn btn-warning"><i class="bi-pencil-fill"></i></button> untuk memperbarui artikel.</li>
              <li><button class="btn btn-danger"><i class="bi-trash3-fill"></i></button> untuk menghapus artikel.</li>
            </ol>
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