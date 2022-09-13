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
          <a href="<?= base_url('menu/tambah'); ?>" class="btn btn-primary rounded-3"><i class="bi-plus-lg"></i><span>Tambah Menu</span></a>
          <a href="<?= base_url('menu/terhapus'); ?>" class="btn btn-danger rounded-3"><i class="bi-trash3-fill me-2"></i><span>Menu Terhapus</span></a>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5">
            <?= $card; ?>
          </div>
          <div class="card-body">
            <table id="menu" class="table align-middle">
              <thead>
                <tr>
                  <th scope="col">Nama Menu</th>
                  <th scope="col">Url Menu</th>
                  <th scope="col">Ikon Menu</th>
                  <th scope="col">Status</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($menus as $m) : ?>
                  <tr>
                    <td><?= $m['nama_menu']; ?></td>
                    <td><?= $m['url_menu']; ?></td>
                    <td><i class="<?= $m['ikon_menu']; ?>"></i></td>
                    <td><span class="badge <?= ($m['menu_active'] == "1") ? "bg-success" : "bg-warning text-dark"; ?>">
                        <?= ($m['menu_active'] == "1") ? "Aktif" : "Nonaktif"; ?></span></td>
                    <td>
                      <div class="dropdown">
                        <a class="text-secondary dropdown-toggle" href="#" role="button" id="dropdown_<?= $m['kd_menu']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                          Aksi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown_<?= $m['kd_menu']; ?>">
                          <li><a class="dropdown-item" href="<?= base_url('/menu/edit/' . $m['kd_menu']); ?>">Ubah</a></li>
                          <?php if ($m['nama_menu'] != "Master Menu") : ?>
                            <li>
                              <div>
                                <form id="deleteMe_<?= $m['kd_menu']; ?>" action="<?= base_url('menu/hapus/' . $m['kd_menu']); ?>" method="post">
                                  <input type="hidden" name="_method" value="DELETE">
                                  <a href="javascript:void(0);" onclick="return confirmation('<?= $m['nama_menu']; ?>','<?= $m['kd_menu']; ?>');" class="dropdown-item">Hapus</a>
                                </form>
                              </div>
                            </li>
                          <?php endif; ?>
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
<script type="text/javascript">
  function confirmation(nama, id) {
    if (confirm("Yakin ingin menghapus data menu : " + nama + "?")) {
      document.getElementById('deleteMe_' + id).submit();
    } else {
      return false;
    }
  }
  $(document).ready(function() {
    $('#menu').DataTable();
  });
</script>
<?= $this->endSection(); ?>