<?php
$db = db_connect();
// $queryMenu = $db->query('SELECT g_menu_all.* FROM g_menu_all WHERE parent = 0 ORDER BY g_menu_all.nomor_urut ')->getResultArray();
$queryMenu = $db->query('SELECT gm.* FROM g_menu_all gm JOIN g_menu_accessable gma ON gm.id = gma.menu_id WHERE kd_group = ' . session()->kd_group . ' AND gm.parent = 0 AND gma.status = 1 ORDER BY gm.nomor_urut;')->getResultArray();
$getGroup = $db->query('SELECT m_user_group.nama FROM m_user_group WHERE kd_group =' . session()->kd_group)->getRow();
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-danger elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="/assets/dist/img/lancar-jaya.png" alt="Logo" style="opacity: .8; height: 30px;">
        <span class="brand-text font-weight-light">Lancar Jaya Express</span>
    </a>
    <a href="https://lancarjayaexpress.com" class="brand-link pl-4">
        <i class="fas fa-globe nav-icon mr-2"></i>
        Kunjungi Website
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <img src="<?= session()->lampiran != '' ? base_url('img/' . session()->lampiran) : '/assets/dist/img/avatar5.png' ?> " class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info text-white">
                <a href="#" class="d-block font-weight-bold text-capitalize"><?= session()->nama ?></a>
                <span><?= $getGroup->nama ?></span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php foreach ($queryMenu as $menu) : ?>
                    <li class="nav-item <?= service('uri')->getSegment(4) == $menu['slug'] || service('uri')->getSegment(3) == $menu['slug'] ? 'menu-is-opening menu-open' : '' ?>">
                        <a href="<?= $menu['url'] ?>" class="nav-link <?= service('uri')->getSegment(4) == $menu['slug'] || service('uri')->getSegment(3) == $menu['slug'] ? 'active' : '' ?> <?= service('uri')->getSegment(1) == '' && $menu['nama_menu'] == 'Dashboard' ? 'active' : '' ?>">
                            <i class="<?= $menu['icon'] ?>"></i>
                            <p>
                                <?= $menu['nama_menu'] ?>
                                <?php if ($menu['isparent'] == 1) : ?>
                                    <i class="fas fa-angle-left right"></i>
                                <?php endif ?>
                            </p>
                        </a>
                        <?php if ($menu['isparent'] == 1) : ?>
                            <?php $subMenuQuery = $db->query('SELECT gm.* FROM g_menu_all gm JOIN g_menu_accessable gma ON gm.id = gma.menu_id WHERE kd_group = ' . session()->kd_group . ' AND gm.parent = ' . $menu['id'] . ' AND gma.status = 1 ORDER BY gm.nomor_urut;')->getResultArray();
                            ?>
                            <ul class="nav nav-treeview">
                                <?php foreach ($subMenuQuery as $subMenu) : ?>
                                    <li class="nav-item">
                                        <a href="<?= $subMenu['url'] ?>" class="nav-link <?= service('uri')->getSegment(3) == $subMenu['slug'] ? 'active' : '' ?>">
                                            <i class="<?= $subMenu['icon'] ?>"></i>
                                            <p><?= $subMenu['nama_menu'] ?></p>
                                            <?php if ($subMenu['isparent'] == 1) : ?>
                                                <i class="fas fa-angle-left right"></i>
                                            <?php endif ?>
                                        </a>

                                        <?php if ($subMenu['isparent'] == 1) : ?>
                                            <?php $subSubMenuQuery = $db->query('SELECT gm.* FROM g_menu_all gm JOIN g_menu_accessable gma ON gm.id = gma.menu_id WHERE kd_group = ' . session()->kd_group . ' AND gm.parent = ' . $subMenu['id'] . ' AND gma.status = 1 ORDER BY gm.nomor_urut;')->getResultArray();
                                            ?>
                                            <ul class="nav nav-treeview">
                                                <?php foreach ($subSubMenuQuery as $subSubMenu) : ?>
                                                    <li class="nav-item">
                                                        <a href="<?= $subSubMenu['url'] ?>" class="nav-link">
                                                            <i class="<?= $subSubMenu['icon'] ?>"></i>
                                                            <p><?= $subSubMenu['nama_menu'] ?></p>
                                                            <?php if ($subSubMenu['isparent'] == 1) : ?>
                                                                <i class="fas fa-angle-left right"></i>
                                                            <?php endif ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach ?>
                                            </ul>

                                        <?php endif ?>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        <?php endif ?>
                    </li>
                <?php endforeach ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>