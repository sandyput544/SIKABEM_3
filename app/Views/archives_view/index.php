<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12 d-flex justify-content-end">
        <div>
          <a href="<?= base_url('arsip/tambah'); ?>" class="btn btn-primary rounded-3"><i class="bi-plus-lg me-2"></i><span>Tambah Posisi</span></a>
          <a href="<?= base_url('arsip/terhapus'); ?>" class="btn btn-danger rounded-3"><i class="bi-trash3-fill me-2"></i><span>Posisi Terhapus</span></a>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5">
            <?= $card; ?>
          </div>
          <div class="card-body">
            <table id="arsip" class="table align-middle table-striped">
              <thead>
                <tr>
                  <th scope="col">Kategori</th>
                  <th scope="col">Nomor Arsip</th>
                  <th scope="col">Nama Arsip</th>
                  <th scope="col">Tanggal Buat</th>
                  <th scope="col">Nama Pembuat</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($archives as $a) : ?>
                  <tr>
                    <td><?= $a['kategori']; ?></td>
                    <td><?= $a['nomor_arsip']; ?></td>
                    <td><?= $a['nama_arsip']; ?></td>
                    <td><?= $a['tgl_buat']; ?></td>
                    <td><?= $a['pembuat']; ?></td>
                    <td>
                      <div class="dropdown">
                        <a class="text-secondary dropdown-toggle" href="#" role="button" id="dropdown_<?= $a['kd_arsip']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                          Aksi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown_<?= $a['kd_arsip']; ?>">
                          <li><a class="dropdown-item" href="<?= base_url('arsip/detail/' . $a['nama_file']); ?>">Lihat</a></li>
                          <li><a class="dropdown-item" href="<?= base_url('arsip/edit/' . $a['kd_arsip']); ?>">Ubah</a></li>
                          <li>
                            <div>
                              <form id="deleteMe_<?= $a['kd_arsip']; ?>" action="<?= base_url('arsip/hapus/' . $a['kd_arsip']); ?>" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="javascript:void(0);" onclick="return confirmation('<?= $a['nama_arsip']; ?>','<?= $a['nomor_arsip']; ?>','<?= $a['kd_arsip']; ?>');" class="dropdown-item">Hapus</a>
                              </form>
                            </div>
                          </li>
                        </ul>
                      </div>
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

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>
<script>
  function confirmation(nama, nomor, id) {
    if (confirm("Yakin ingin menghapus data arsip : " + nama + " dengan nomor arsip : " + nomor + "?")) {
      document.getElementById('deleteMe_' + id).submit();
    } else {
      return false;
    }
  }
  $(document).ready(function() {
    $('#arsip').DataTable();
  });
</script>
<?= $this->endSection(); ?>