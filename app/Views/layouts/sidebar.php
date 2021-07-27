<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-danger elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="/assets/dist/img/lancar-jaya.png" alt="Logo" style="opacity: .8; height: 30px;">
        <span class="brand-text font-weight-light">Lancar Jaya Express</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">

                    <a href="/" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-server"></i>
                        <p>
                            Master
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/kirim/master') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Biaya Kirim</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/jenis_kirim/master') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jenis Biaya Kirim</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/layanan/master') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Layanan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/lokasi/master') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lokasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/customer/master') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Customer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/pegawai/master') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pegawai</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/kas/master') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>kas</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>
                            Pengiriman
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/pengiriman/pengiriman') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengiriman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/manifest_out/pengiriman') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Manifest
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/load/add/manifest_in/pengiriman" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Manifest Masuk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/load/add/manifest_out/pengiriman" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Manifest Keluar</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/invoice/pengiriman') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Invoice</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/add/penagihan/pengiriman') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penagihan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/pembayaran/pengiriman') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pembayaran</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="<?= base_url('/load/view/tpendapatan/other') ?>" class="nav-link">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>
                            Pendapatan
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="<?= base_url('/load/view/biaya_operasional/other') ?>" class="nav-link">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>
                            Biaya
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="<?= base_url('/load/view/mutasi_kas/other') ?>" class="nav-link">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>
                            Mutasi Kas
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Laporan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/omset_pengiriman/laporan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Omset Pengiriman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/piutang_aktif/laporan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Piutang Aktif</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/biaya_operasional/laporan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Biaya Operasional</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/laba_rugi/laporan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laba Rugi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/saldo_kas_akhir/laporan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Saldo Kas Akhir</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/histori_kas/laporan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Histori Kas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('/load/view/status_pengiriman/laporan') ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Status Pengiriman</p>
                            </a>
                        </li>
                    </ul>
                <li class="nav-item has-treeview">
                    <a href="<?= base_url('/load/view/users') ?>" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="<?= base_url('/load/view/pengaturan') ?>" class="nav-link">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>
                            Pengaturan
                        </p>
                    </a>
                </li>
                </li>
                <li class="nav-item has-treeview">
                    <a href="<?= base_url('/api/logout') ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt" aria-hidden="true"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>