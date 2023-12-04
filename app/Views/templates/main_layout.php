<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SKPI | <?= $title ?? '' ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css') ?>">
    <!-- icon -->
    <link rel="shortcut icon" href="<?= base_url('img/web/logo2.ico') ?>" type="image/x-icon">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('adminlte') ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- custom page style -->
    <?= $this->renderSection('style') ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= base_url() ?>" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" id="logout" href="#" role="button">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url() ?>" class="brand-link">
                <img src="<?= base_url('img/web/logo2.png') ?>" alt="BPM Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">SKPI Dashboard</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url('img/avatar/' . user()->avatar) ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= user()->name ?></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <?php if (in_groups('admin')) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('user-management') ?>" class="nav-link <?= url_is('user-management') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        User Management
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (in_groups('admin', 'bpm')) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('prodi-fakultas-management') ?>" class="nav-link <?= url_is('prodi-fakultas-management') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-th-list"></i>
                                    <p>
                                        Prodi & Fakultas Management
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('gelar-management') ?>" class="nav-link <?= url_is('gelar-management') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-graduation-cap"></i>
                                    <p>
                                        Gelar Management
                                    </p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item <?= url_is('form-management*') ? 'menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= url_is('form-management*') ? 'active' : '' ?>">
                                <i class="nav-icon fab fa-wpforms"></i>
                                <p>
                                    Form SKPI Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url('form-management/penyelenggara-program-management') ?>" class="nav-link <?= url_is('form-management/penyelenggara-program-management') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Penyeleggara Program Management</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('form-management/kemampuan-bidang-umum-management') ?>" class="nav-link <?= url_is('form-management/kemampuan-bidang-umum-management') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Kemampuan Bidang Umum</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('form-management/kemampuan-bidang-khusus-management') ?>" class="nav-link <?= url_is('form-management/kemampuan-bidang-khusus-management') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Kemampuan Bidang Khusus</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('form-management/penguasaan-pengetahuan-management') ?>" class="nav-link <?= url_is('form-management/penguasaan-pengetahuan-management') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Penguasaan Pengetahuan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('form-management/penguasaan-sikap-management') ?>" class="nav-link <?= url_is('form-management/penguasaan-sikap-management') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Penguasaan Sikap</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('form-management/ditjen-dikti-management') ?>" class="nav-link <?= url_is('form-management/ditjen-dikti-management') ? 'active' : '' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Ditjen Dikti</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="<?= base_url('form-skpi') ?>" class="nav-link <?= url_is('form-skpi') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    List Form SKPI
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <?= $this->renderSection('page-header') ?>
            <!-- /.content-header -->

            <!-- Main content -->
            <?= $this->renderSection('main-content'); ?>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- Default to the left -->
            <strong>Copyright &copy;<a href="<?= base_url() ?>">BPM</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?= base_url('adminlte/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('adminlte/dist/js/adminlte.min.js') ?>"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url('adminlte') ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        const base_url = '<?= base_url() ?>';

        $('#logout').click(function(e) {
            Swal.fire({
                title: "Konfirmasi Logout?",
                text: "Apakah anda ingin Logout?!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Logout!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = base_url + '/logout';
                }
            });
        })

        $('input[type="file"]').change(function(e) {
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });

        // handle flash data message-success
        <?php if ($messageSuccess = session()->getFlashdata('message-success')) : ?>
            Swal.fire({
                title: "Berhasil!",
                text: "<?= $messageSuccess ?>",
                icon: "success"
            });
        <?php endif; ?>


        // handle error validation message
        <?php if ($messagefailed = session()->getFlashdata('_ci_validation_errors')) : ?>
            Swal.fire({
                title: "Gagal!",
                html: `<?= implode('</br>', unserialize($messagefailed)) ?>`,
                icon: "error"
            });
        <?php endif; ?>
    </script>
    <!-- custom page script -->
    <?= $this->renderSection('script') ?>
</body>

</html>