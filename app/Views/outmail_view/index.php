<?= $this->extend('\backend-template\index'); ?>
<?= $this->section('content'); ?>

<div class="row">
  <?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan'); ?>
  <?php endif; ?>
  <div class="col-12">
    <div class="row g-3">
      <div class="col-12 d-flex">
        <div class="me-auto">
          <a href="<?= base_url('jenis-surat'); ?>" class="btn btn-secondary"><i class="bi-bookmark-fill me-2"></i><span>Jenis Surat</span></a>
        </div>
        <div class="ms-auto">
          <a href="<?= base_url('surat-keluar/buat'); ?>" class="btn btn-primary"><i class="bi-plus-lg me-2"></i><span>Buat Surat</span></a>
          <a href="<?= base_url('surat-keluar/terhapus'); ?>" class="btn btn-danger"><i class="bi-trash3-fill me-2"></i><span>Surat Terhapus</span></a>
        </div>
      </div>
      <div class="col-12">
        <div class="card text-dark shadow overflow-hidden rounded-4">
          <div class="card-header fw-bold fs-5 d-flex justify-content-between">
            <?= $card; ?>
          </div>
          <div class="card-body">
            <table id="surat" class="table align-middle table-striped">
              <thead>
                <tr>
                  <th scope="col">Jenis Surat</th>
                  <th scope="col">Nomor Surat</th>
                  <th scope="col">Nama Pembuat</th>
                  <th scope="col">Tanggal Buat</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($mail as $m) : ?>
                  <tr>
                    <td><?= $m['nama_jenis']; ?></td>
                    <td><?= $m['nomor_surat']; ?></td>
                    <td><?= ($m['id_user'] = 0) ? $m['nama_user'] : "-"; ?></td>
                    <td><?= $m['waktu_buat']; ?></td>
                    <td>
                      <div class="dropdown">
                        <a class="text-secondary dropdown-toggle" href="#" role="button" id="dropdown_<?= $m['kd_suratkeluar']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                          Aksi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown_<?= $m['kd_suratkeluar']; ?>">
                          <li><a class="dropdown-item" href="<?= base_url('/surat-keluar/edit/' . $m['kd_suratkeluar']); ?>">Ubah</a></li>
                          <li>
                            <div>
                              <form id="deleteMe_<?= $m['kd_suratkeluar']; ?>" action="<?= base_url('surat-keluar/hapus/' . $m['kd_suratkeluar']); ?>" method="post">
                                <input type="hidden" name="_method" value="DELETE">
                                <a href="javascript:void(0);" onclick="return confirmation('<?= $m['nama_jenis']; ?>','<?= $m['nomor_surat']; ?>','<?= $m['kd_suratkeluar']; ?>');" class="dropdown-item">Hapus</a>
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
    if (confirm("Yakin ingin menghapus data surat : " + nama + " dengan nomor surat : " + nomor + "?")) {
      document.getElementById('deleteMe_' + id).submit();
    } else {
      return false;
    }
  }
  $(document).ready(function() {
    $('#surat').DataTable({
      order: [
        [1, 'desc']
      ],
    });
  });
</script>
<?= $this->endSection(); ?>