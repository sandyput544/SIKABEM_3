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
          <a href="<?= base_url('/user/tambah'); ?>" class="btn btn-primary rounded-3"><i class="bi-plus-lg me-2"></i><span>Tambah User</span></a>
          <a href="<?= base_url('/user/terhapus'); ?>" class="btn btn-danger rounded-3"><i class="bi-trash3-fill me-2"></i><span>User Terhapus</span></a>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= $card; ?>
          </div>
          <div class="card-body">
            <table id="users" class="table align-middle table-striped">
              <thead>
                <tr>
                  <th scope="col">Nama Lengkap</th>
                  <th scope="col">Jabatan</th>
                  <th scope="col">Tanggal Terdaftar</th>
                  <th scope="col">Status</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($users as $u) : ?>
                  <tr>
                    <td><?= $u['nama_user']; ?></td>
                    <td><?= ($u['id_jbt'] == 0) ? "Belum memiliki jabatan" : $u['jabatan']; ?></td>
                    <td><?= $u['tgl_terdaftar']; ?></td>
                    <td><span class="badge <?= ($u['user_active'] == "1") ? "bg-success" : "bg-warning text-dark"; ?>">
                        <?= ($u['user_active'] == "1") ? "Aktif" : "Nonaktif"; ?></span></td>
                    <td>
                      <?php if ($u['is_login'] == 0) : ?>
                        <div class="dropdown">
                          <a class="text-secondary dropdown-toggle" href="#" role="button" id="dropdown<?= $u['kd_user']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                            Aksi
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdown<?= $u['kd_user']; ?>">
                            <li><a class="dropdown-item" href="<?= base_url('/user/edit/' . $u['kd_user']) ?>">Ubah</a></li>
                            <li>
                              <div>
                                <form id="deleteMe_<?= $u['kd_user']; ?>" action="<?= base_url('user/hapus/' . $u['kd_user']) ?>" method="post">
                                  <input type="hidden" name="_method" value="DELETE">
                                  <a href="javascript:void(0);" onclick="return confirmation('<?= $u['nama_user']; ?>','<?= $u['kd_user']; ?>');" class="dropdown-item">Hapus</a>
                                </form>
                              </div>
                            </li>
                          </ul>
                        </div>
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

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
  function confirmation(nama, id) {
    if (confirm("Yakin ingin menghapus data user : " + nama + "?")) {
      document.getElementById('deleteMe_' + id).submit();
    } else {
      return false;
    }
  }
  $(document).ready(function() {
    $('#users').DataTable();
  });
</script>
<?= $this->endSection(); ?>