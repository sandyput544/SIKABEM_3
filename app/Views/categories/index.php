<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12 d-flex">
        <div class="ms-auto">
          <a href="<?= base_url('kategori/tambah'); ?>" class="btn btn-primary rounded-3"><i class="bi-plus-lg"></i><span>Tambah Kategori</span></a>
          <a href="<?= base_url('kategori/terhapus'); ?>" class="btn btn-danger rounded-3"><i class="bi-trash3-fill me-2"></i><span>Kategori Terhapus</span></a>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= $card; ?>
          </div>
          <div class="card-body">
            <table id="kat" class="table align-middle table-striped">
              <thead>
                <tr>
                  <th scope="col">Nama Kategori</th>
                  <th scope="col">Singkatan</th>
                  <th scope="col">Jumlah Arsip</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($categories as $c) : ?>
                  <tr>
                    <td><?= $c['nama_kat']; ?></td>
                    <td><?= $c['singkatan_kat']; ?></td>
                    <td><?php
                        $cat_id = $c['kd_kategori'];
                        echo  $getRows = $instance
                          ->where('kd_kategori', $cat_id)
                          ->countAllResults();
                        ?> arsip tersimpan</td>
                    <td>
                      <div class="dropdown">
                        <a class="text-secondary dropdown-toggle" href="#" role="button" id="dropdown_<?= $c['kd_kategori']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                          Aksi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown_<?= $c['kd_kategori']; ?>">
                          <li><a class="dropdown-item" href="<?= base_url('/kategori/edit/' . $c['kd_kategori']); ?>">Ubah</a></li>
                          <li>
                            <div>
                              <form id="deleteMe_<?= $c['kd_kategori']; ?>" action="<?= base_url('kategori/hapus/' . $c['kd_kategori']); ?>" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="javascript:void(0);" onclick="return confirmation('<?= $c['nama_kat']; ?>','<?= $c['kd_kategori']; ?>');" class="dropdown-item">Hapus</a>
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
  function confirmation(nama, id) {
    if (confirm("Yakin ingin menghapus data kategori : " + nama + "?")) {
      document.getElementById('deleteMe_' + id).submit();
    } else {
      return false;
    }
  }
  $(document).ready(function() {
    $('#kat').DataTable();
  });
</script>
<?= $this->endSection(); ?>