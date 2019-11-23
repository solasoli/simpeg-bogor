<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SIMPEG API Documentation</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/bootstrap4/css/bootstrap.css'); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/build/dashboard.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/build/sticky-footer.css'); ?>" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="<?php echo base_url('assets/DataTables-2/datatables.min.css'); ?>" rel="stylesheet">

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('assets/build/jquery-slim.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/build/popper.min.js'); ?>"></script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url('assets/jquery/dist/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/bootstrap4/js/bootstrap.js'); ?>"></script>

    <!-- DataTables JS -->
    <script src="<?php echo base_url('assets/DataTables-2/datatables.min.js'); ?>"></script>
</head>

<body>
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="<?php echo base_url('Docs') ?>">
        <img src='<?php echo base_url('assets/images/logokotabogor.gif'); ?>'
             style="width:20px;border: 1px solid dimgrey;" /> &nbsp;SIMPEG REST API</a>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Pencarian" aria-label="Search" style="border-bottom: solid 1px grey">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="#"><span data-feather="search"></span> Cari</a>
        </li>
    </ul>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="<?php echo base_url('Docs/logout') ?>"><span data-feather="log-out"></span> Sign out</a>
        </li>
    </ul>
</nav>
<?php
    $lvlUser = $this->session->userdata('user_level');
?>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <!--<li class="nav-item">
                        <a class="nav-link active" href="<?php //echo base_url('Docs') ?>">
                            <span data-feather="home"></span>
                            Dashboard <span class="sr-only">(current)</span>
                        </a>
                    </li>-->

                    <?php if($lvlUser=='User'): ?>
                    <span class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">
                    <div class="row" style="padding-top: 5px;">
                        <div class="col-sm-2">
                            <img src='../../../../simpeg/foto/<?php echo $this->session->userdata('id_pegawai')?>.jpg'
                                 style="width:25px;border: 1px solid dimgrey; border-radius: 3px;" />
                        </div>
                        <div class="col-sm-10">
                            <span style="color: cornflowerblue;"><?php echo '<strong>'.$this->session->userdata('nama').'</strong><br>'.
                                    $this->session->userdata('nip'); ?></span>
                        </div>
                    </div>
                    </span>
                    <?php endif; ?>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Kategori API</span>
                        <a class="d-flex align-items-center text-muted">
                            <span data-feather="package"></span>
                        </a>
                    </h6>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Docs/doc_android') ?>">
                            <span data-feather="smartphone"></span>
                            Android <span class="badge badge-pill badge-info"><?php echo $jmlMthAndro; ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Docs/doc_jabatan') ?>">
                            <span data-feather="star"></span>
                            Jabatan <span class="badge badge-pill badge-info"><?php echo $jmlMthJabatan; ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Docs/doc_pegawai') ?>">
                            <span data-feather="users"></span>
                            Pegawai <span class="badge badge-pill badge-info"><?php echo $jmlMthPegawai; ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Docs/doc_unit_kerja') ?>">
                            <span data-feather="layers"></span>
                            Unit Kerja <span class="badge badge-pill badge-info"><?php echo $jmlMthUnit; ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Docs/doc_statistik') ?>">
                            <span data-feather="bar-chart-2"></span>
                            Statistik <span class="badge badge-pill badge-info"><?php echo $jmlMthStat; ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Docs/doc_ekinerja') ?>">
                            <span data-feather="briefcase"></span>
                            E-Kinerja <span class="badge badge-pill badge-info"><?php echo $jmlMthEkinerja; ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Docs/how_to_share') ?>">
                            <span data-feather="share-2"></span> Cara Berbagi Data
                        </a>
                    </li>
                    <?php if($lvlUser=='User'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('Docs/logout') ?>">
                                <span data-feather="log-out"></span>
                                Sign Out
                            </a>
                        </li>
                    <?php endif;?>
                </ul>
                <?php if($lvlUser=='Administrator'): ?>
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Rest Administrator</span>
                    <a class="d-flex align-items-center text-muted">
                        <span data-feather="edit"></span>
                    </a>
                </h6>
                <span class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">
                    <div class="row" style="padding-top: 5px;">
                        <div class="col-sm-2">
                            <img src='../../../../simpeg/foto/<?php echo $this->session->userdata('id_pegawai')?>.jpg'
                                 style="width:25px;border: 1px solid dimgrey; border-radius: 3px;" />
                        </div>
                        <div class="col-sm-10">
                            <span style="color: cornflowerblue;"><?php echo '<strong>'.$this->session->userdata('nama').'</strong><br>'.
                                    $this->session->userdata('nip'); ?></span>
                        </div>
                    </div>
                </span>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Administrator/entitas_list') ?>">
                            <span data-feather="pocket"></span>
                            Kategori API &laquo; Entitas &raquo;
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Administrator') ?>">
                            <span data-feather="list"></span>
                            Daftar Method
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Administrator/add_new_methode') ?>">
                            <span data-feather="plus-square"></span>
                            Tambah Methode Baru
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Administrator/application_list') ?>">
                            <span data-feather="aperture"></span>
                            Daftar Aplikasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Administrator/methode_access_list') ?>">
                            <span data-feather="activity"></span>
                            Akses Methode
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Administrator/admin_list') ?>">
                            <span data-feather="user-check"></span>
                            Daftar Pengguna
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Administrator/log_access_list') ?>">
                            <span data-feather="clock"></span>
                            Log Akses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('Docs/logout') ?>">
                            <span data-feather="log-out"></span>
                            Sign Out
                        </a>
                    </li>
                </ul>
                <?php endif;?>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2"><?php echo $judul; ?></h1>
            </div>
            <?php $this->load->view($main_view); ?>
        </main>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <span class="text-muted">Copyright &copy; 2018 Badan Kepegawaian dan Pengembangan Sumber Daya Aparatur Kota Bogor</span>
    </div>
</footer>

</body>
</html>

<!-- Icons -->
<!--<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>-->
<script src="<?php echo base_url('assets/feather.min.js'); ?>"></script>
<script>
    feather.replace();
</script>
