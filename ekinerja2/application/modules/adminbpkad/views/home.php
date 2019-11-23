<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SIMPEG e-Kinerja Bogor</title>
    <!-- Metro core CSS -->
    <link href="<?php echo base_url('assets/metro4/css/metro-all.css'); ?>" rel="stylesheet">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url('assets/jquery/dist/jquery-3.3.1.min.js'); ?>"></script>

    <script src="<?php echo base_url('assets/metro4/js/metro.js'); ?>"></script>

</head>

<body class="bg-grayBlue">
<div class="container">
    <div class="pos-relative app-bar-expand-md app-bar bg-darkOrange fg-white" data-role="appbar">
        <button type="button" class="hamburger menu-down dark hidden">
            <span class="line"></span><span class="line"></span><span class="line"></span></button>


        <a class="brand no-hover" href="<?php echo base_url('adminbpkad') ?>">
            <img src='<?php echo base_url('assets/images/logokotabogor.gif'); ?>'
                 style="width:30px;" /> &nbsp;&nbsp;<strong>SIMPEG e-Kinerja Kota Bogor</strong></a>

        <ul class="app-bar-menu ml-auto">
            <li><a href="<?php echo base_url('adminbpkad') ?>">Dashboard</a></li>
            <li><a href="#">Kinerja Saya</a></li>
            <li><a href="#">Statistik</a></li>
            <li><a href="#">Forum</a></li>
            <li>
                <a href="#" class="dropdown-toggle">Profil Saya</a>
                <ul class="d-menu" data-role="dropdown">
                    <li><a href="#">Daftar Riwayat Hidup</a></li>
                    <li><a href="#">Riwayat Hukuman Disiplin</a></li>
                    <li class="divider bg-lightGray"></li>
                    <li><a href="#">Ubah Password</a></li>
                </ul>
            </li>
            <li><a href="#">Panduan Penggunaan</a></li>
            <li><a href="<?php echo base_url('adminbpkad/logout') ?>">Logout</a></li>
        </ul>
    </div>
    <div style="height: 700px;">
        <div data-role="navview" data-compact="md" data-expanded="lg" data-toggle="#pane-toggle" class="navview compact-md expanded-lg">
            <nav class="navview-pane" style="border-right: solid 1px rgba(71,71,72,0.35)">
                <div class="sidebar-header bg-lightSteel"
                     style="overflow-y: scroll; height: 200px; background-image: url('<?php echo base_url('assets/images/sidebar-4.png'); ?>'); ">

                    <?php
                    if (file_exists($_SERVER['DOCUMENT_ROOT']."/simpeg/foto/".$this->session->userdata('id_pegawai').'.jpg')) {
                        $nmfile = $this->session->userdata('id_pegawai');
                    }else{
                        $nmfile = 'nophoto';
                    }
                    ?>

                    <div class="avatar">
                        <img src='../../../../simpeg/foto/<?php echo $nmfile;?>.jpg' style="width:60px;" />
                    </div>
                    <span class="title" style="margin-top: -10px;color: white;"><?php echo '<strong>'.$ses_nama.'</strong>'?></span>
                    <span class="subtitle" style="color: white;"><?php echo $ses_nip.'<br>'.$ses_unit.'<br>'.$ses_lvl_name; ?></span>
                </div>

                <ul class="sidenav-simple sidenav-simple-expand-fs" style="width: 100%;">
                    <li <?php echo ($page=='dashboard'?'class="active"':''); ?>><a href="<?php echo base_url('adminbpkad') ?>">
                            <span class="mif-dashboard icon"></span>
                            <span class="title">Dashboard</span>
                        </a></li>
                    <li <?php echo ($page=='input_aktifitas'?'class="active"':''); ?>><a href="<?php echo base_url('adminbpkad/input_aktifitas') ?>">
                            <span class="mif-pencil icon"></span>
                            <span class="title">Input Aktifitas Harian</span>
                        </a></li>
                    <li <?php echo ($page=='kinerja_pegawai'?'class="active"':''); ?>><a href="<?php echo base_url('adminbpkad/kinerja_pegawai') ?>">
                            <span class="mif-book-reference icon"></span>
                            <span class="title">Info Kinerja Pegawai</span>
                        </a></li>
                    <li <?php echo ($page=='list_riwayat_kinerja'?'class="active"':''); ?>><a href="<?php echo base_url('adminbpkad/list_riwayat_kinerja') ?>">
                            <span class="mif-description icon"></span>
                            <span class="title">Daftar Kegiatan</span>
                        </a></li>
                    <li <?php echo ($page=='download_data'?'class="active"':''); ?>><a href="<?php echo base_url('adminbkpsda/download_data') ?>">
                            <span class="mif-download icon"></span>
                            <span class="title">Download Data</span>
                        </a></li>
                </ul>
            </nav>
            <div class="navview-content pl-4-md pr-4-md">
                <div style="margin-top: 20px;"><?php $this->load->view($main_view); ?></div>
            </div>
        </div>
    </div>
    <footer class="container-fluid bg-lightGray p-4">
        <div class="row">
            <div class="cell-md-6">
                <ul class="inline-list h-menu no-hover bg-lightGray" style="margin-left: -.5rem">
                    <li><a href="http://simpeg.kotabogor.go.id/web/" target="_blank">BKPSDA</a></li>
                    <li><a href="http://simpeg.kotabogor.go.id" target="_blank">SIMPEG</a></li>
                </ul>
                <p>
                    Aplikasi e-Kinerja &copy; 2018 by <a href="simpeg.kotabogor@gmail.com" class="no-wrap">SIMPEG Kota Bogor</a>.
                    <br />
                    <span class="no-wrap">Badan Kepegawaian, dan Pengembangan Sumberdaya Aparatur Kota Bogor </span>
                </p>
            </div>
            <div class="cell-md-6">
                <!-- ads-html -->
            </div>
        </div>
    </footer>
</div>
</body>
</html>