<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/FA5PRO-6.0/css/all.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">

        <!-- jQuery -->
        <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>

        <!-- Bootstrap 4 -->
        <script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Datatable -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/DataTables/datatables.min.css"/>
        <script type="text/javascript" src="<?= base_url() ?>assets/DataTables/datatables.min.js"></script>

        <link rel="stylesheet" href="<?= base_url() ?>assets/css/animate.min.css">
        <script src="<?= base_url() ?>assets/js/animateCSS_dan_alert.js"></script>

        <style>
            .left-col {
                float: left;
                width: 50%;
            }
            .center-col {
                float: left;
                width: 0%;
            }
            .right-col {
                float: left;
                width: 50%;
            }
        </style>
    </head>
    <body class="hold-transition sidebar-mini">

        <!-- Modal -->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        Apakah yakin ingin melanjutkan?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <a href="" id="ok-button" class="btn btn-primary">OK</a>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="informasiModal" tabindex="-1" role="dialog" aria-labelledby="informasiModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-exclamation-circle"></i> Informasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Modal -->

        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>

                    <!-- 
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="" class="nav-link">Home</a>
                    </li>
                    -->
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <button class="btn dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= base_url() ?>assets/dist/img/avatar5.png" class="user-image" alt="User Image"/>
                            <span class="hidden-xs text-black"><?= $this->session->userdata['namaUser'] ?></span>
                        </button>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?= base_url() ?>assets/dist/img/avatar5.png" class="img-circle" alt="User Image" />
                                <div class="my-2 text-bold"><?= $this->session->userdata['namaUser'] ?></div>                                     
                                <div id="email_user"><?= $this->session->userdata['email'] ?></div>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div  class="float-left">
                                    <a  href="<?= base_url() ?>ganti_password" class="btn btn-default btn-flat">Change Password</a>

                                </div>
                                <div class="float-right">
                                    <a href="<?= base_url() ?>auth/logout" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>

            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="#" class="brand-link mb-3">
                    <span class="brand-text font-weight-light">Inventory GA Utility</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">

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

                            <!-- Menu Dashboard -->
                            <li class="nav-item">
                                <a href="<?= base_url() ?>dashboard" class="nav-link <?php echo strtolower($link) == 'dashboard' ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>

                            <!-- Menu Header -->
                            <?php if (!empty($menu)): ?>
                                <?php foreach ($menu as $kategori => $menu): ?>
                                    <li class="nav-header"><?= strtoupper($kategori) ?></li>

                                    <!-- Menu Tree / Master Menu -->
                                    <?php foreach ($menu['menuMaster'] as $namaMenuMaster => $dataMenuMaster): ?>
                                        <li class="nav-item menu-open">                                

                                            <a href="#" class="nav-link <?php echo strtolower($master) == strtolower($namaMenuMaster) ? 'active' : '' ?>">
                                                <i class="nav-icon fas fa-book"></i>
                                                <p>
                                                    <?= ucwords($namaMenuMaster) ?>
                                                    <i class="right fas fa-angle-left"></i>
                                                </p>
                                            </a>

                                            <?php foreach ($dataMenuMaster as $dataSubmenu): ?>
                                                <ul class="nav nav-treeview">

                                                    <li class="nav-item">
                                                        <a href="<?= base_url() . $dataSubmenu['link'] ?>" class="nav-link <?php echo strtolower($link) == strtolower($dataSubmenu['link']) ? 'active' : '' ?>">
                                                            <i class="fas <?= $dataSubmenu['icon'] ?> nav-icon"></i>
                                                            <p><?= ucwords($dataSubmenu['nama_menu']) ?></p>
                                                        </a>
                                                    </li>

                                                </ul>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </li>

                                    <?php foreach ($menu['menuSingle'] as $daftarMenuSingle): ?>
                                        <!-- Single Menu -->
                                        <li class="nav-item">
                                            <a href="<?= base_url() . $daftarMenuSingle['link'] ?>" class="nav-link <?php echo strtolower($link) == strtolower($daftarMenuSingle['link']) ? 'active' : '' ?>">
                                                <i class="nav-icon fas <?= $daftarMenuSingle['icon'] ?>"></i>
                                                <p>
                                                    <?= ucwords($daftarMenuSingle['nama_menu']) ?>
                                                </p>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>

                                <?php endforeach; ?> 
                            <?php endif; ?>

                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <?php if ($this->session->flashdata('status') == 'sukses_message') : ?>
                <script>
                    $('#informasiModal .modal-body').html('<?= $this->session->flashdata('message') ?>');
                    $('#informasiModal').modal('show');
                </script>
            <?php endif; ?>

            <?php if ($this->session->flashdata('status') == 'error_message') : ?>
                <script>
                    $('#informasiModal .modal-body').html('<?= $this->session->flashdata('message') ?>');
                    $('#informasiModal').modal('show');
                </script>
            <?php endif; ?>
