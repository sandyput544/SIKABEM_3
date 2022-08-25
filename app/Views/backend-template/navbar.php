<?php
// $memberlevel = session('memberlevel_id');
// $role = session('role_id');
$menus = new \App\Models\MenusModel();

$query = $menus
  // ->join('position_menu', 'position_menu.menu_id = menus.id')
  // ->join('positions', 'positions.id = position_menu.pos_id')
  // ->where('position_menu.pos_id = ' . session('pos_id'))
  // ->where('menus.is_active=1')
  ->findAll();

?>

<nav class="d-flex flex-column p-3 text-white bg-dark-bem left-side" id="leftSideContent">
  <a href="/" class="d-flex justify-content-center text-white text-decoration-none">
    <span class="fs-4 fw-bold">SIBEM PNC</span>
  </a>
  <hr class="text-orange-bem">
  <ul class="nav d-flex flex-row mb-auto gap-3">
    <li>
      <a href="/profil" class="navlink <?= ($navbar == 'Profil Saya') ? "active" : ''; ?>">
        <i class="bi-person-fill"></i>
        <span>Profil Saya</span>
      </a>
    </li>

    <!-- Tampilkan menu dari user_menu_accesses berdasarkan  -->
    <?php foreach ($query as $q) : ?>
      <li>
        <a href="<?= base_url($q['url_menu']); ?>" class="navlink <?= ($navbar == $q['nama_menu']) ? "active" : ''; ?>">
          <i class="<?= $q['ikon_menu']; ?>"></i>
          <span><?= $q['nama_menu']; ?></span>
        </a>
      </li>
    <?php endforeach; ?>

    <li>
      <a href="/koleksi" class="navlink <?= ($navbar == 'Koleksi Arsip') ? "active" : ''; ?>">
        <i class="bi-collection-fill"></i>
        <span>Koleksi Arsip</span>
      </a>
    </li>
    <li>
      <a href="/auth/logout" class="navlink">
        <i class="bi-box-arrow-right"></i>
        <span>Log Out</span>
      </a>
    </li>
  </ul>
  <!-- <footer class="col-12 fs-6 text-secondary mt-auto">
    <hr class="text-">
    <div class="container-fluid d-flex align-items-center">
      <span>&copy; 2021 Company, Inc</span>
    </div>
  </footer> -->
</nav>