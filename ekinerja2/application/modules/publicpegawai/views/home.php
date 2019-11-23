<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<link rel="icon" type="image/png" href="<?php echo base_url('assets/images/logokotabogor.gif'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SIMPEG e-Kinerja Bogor</title>
    <!-- Metro core CSS -->
    <link href="<?php echo base_url('assets/metro4/css/metro-all.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/jquery/dist/jquery-confirm.min.css'); ?>" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url('assets/jquery/dist/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/metro4/js/metro.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/jquery/dist/jquery-confirm.min.js'); ?>"></script>
</head>

<?php
if (file_exists($_SERVER['DOCUMENT_ROOT']."/simpeg/foto/".$this->session->userdata('id_pegawai').'.jpg')) {
    $nmfile = $this->session->userdata('id_pegawai');
}else{
    $nmfile = 'nophoto';
}
?>

<body class="bg-grayBlue">
<div class="container">
    <?php
        if(isset($_GET['hideHeader']) and $_GET['hideHeader']=='82E31041DBF77D33ECB974A6B27ECD22862241A5ABFFCA72FD8C75B6AEE02932'){
            $_SESSION['hideHeader'] = 1;
        }
        if(isset($_SESSION['hideHeader']) and $_SESSION['hideHeader']!=''):

            ?>

    <?php else: ?>
    <div class="pos-relative app-bar-expand-md app-bar bg-darkEmerald fg-white" data-role="appbar">
        <button type="button" class="hamburger menu-down dark hidden">
            <span class="line"></span><span class="line"></span><span class="line"></span></button>
        <a class="brand no-hover" href="<?php echo base_url('publicpegawai') ?>">
            <img src='<?php echo base_url('assets/images/logokotabogor.gif'); ?>'
                 style="width:30px;" /> &nbsp;&nbsp;<strong>SIMPEG e-Kinerja Kota Bogor</strong></a>
        <ul class="app-bar-menu ml-auto">
            <li class="active"><a href="<?php echo base_url('publicpegawai') ?>">Dashboard</a></li>
            <li><a href="<?php echo base_url('publicpegawai/statistikpegawai') ?>">Statistik</a></li>
            <!--<li><a href="#">Forum</a></li>-->
            <li>
                <a href="#" class="dropdown-toggle">Profil Saya</a>
                <ul class="d-menu" data-role="dropdown">
                    <li><a href="<?php echo base_url('publicpegawai/daftar_riwayat_hidup') ?>">Daftar Riwayat Hidup</a></li>
                    <li><a href="<?php echo base_url('publicpegawai/hukuman_disiplin') ?>">Riwayat Hukuman Disiplin</a></li>
                    <li class="divider bg-lightGray"></li>
                    <li><a href="<?php echo base_url('publicpegawai/ubah_password') ?>">Ubah Password</a></li>
                </ul>
            </li>
            <li><a href="#">Panduan Penggunaan</a></li>
            <li><a href="<?php echo base_url('publicpegawai/logout') ?>">Logout</a></li>
        </ul>
    </div>
    <?php endif; ?>
    <div>

        <div class="p-0 no-overflow bg-white" style="min-height: 700px;">
            <aside class="sidebar pos-absolute z-2"
                   data-role="sidebar"
                   data-toggle="#sidebar-toggle-3"
                   id="sb3"
                   data-shift=".shifted-content"
                   data-static-shift=".shifted-content"
                   data-static="md" style="background-color: #F8F8F8">
                <div class="sidebar-header bg-lightSteel"
                     style="height: 220px; background-image: url('<?php echo base_url('assets/images/sidebar-3.png'); ?>'); ">
                    <div class="avatar">
                        <img src='../../../../simpeg/foto/<?php echo $nmfile;?>.jpg' style="width:60px;" />
                    </div>
                    <span class="title" style="margin-top: -10px;color: white;"><?php echo '<strong>'.$ses_nama.'</strong>'?></span>
                    <span class="subtitle" style="color: white;"><?php echo $ses_nip.'<br>'.$ses_unit.'<br>'.$ses_lvl_name; ?></span>
                </div>
                <ul class="sidenav-simple sidenav-simple-expand-fs" style="width: 100%;height: auto">
                    <li <?php echo ($page=='dashboard'?'class="active"':''); ?>><a href="<?php echo base_url('publicpegawai') ?>">
                            <span class="mif-dashboard icon"></span>
                            <span class="title">Dashboard</span>
                        </a></li>
                    <li <?php echo (($page=='input_laporan_kinerja' or $page=='detail_laporan_kinerja')?'class="active"':''); ?>><a href="<?php echo base_url('publicpegawai/input_laporan_kinerja') ?>">
                            <span class="mif-pencil icon"></span>
                            <span class="title">Input Laporan Kinerja</span>
                        </a></li>
                    <li <?php echo ($page=='list_riwayat_kinerja'?'class="active"':''); ?>><a href="<?php echo base_url('publicpegawai/list_riwayat_kinerja') ?>">
                            <span class="mif-description icon"></span>
                            <span class="title">Riwayat Kegiatan</span>
                        </a></li>
                    <?php //if($this->session->userdata('id_j')!=''): ?>
                    <li <?php echo (($page=='peninjauan_kinerja_staf' or $page=='peninjauan_staf_detail' or $page=='peninjauan_riwayat_staf' or
                        $page=='list_detail_laporan_kinerja_staf' or $page=='detail_nilai_kinerja_staf' or $page=='peninjauan_riwayat_staf_plh' or
                        $page=='peninjauan_staf_detail_plh')?'class="active"':''); ?>><a href="<?php echo base_url('publicpegawai/peninjauan_kinerja_staf') ?>">
                            <span class="mif-book-reference icon"></span>
                            <span class="title">Peninjauan Staf</span>
                        </a></li>
                    <?php //endif; ?>
                    <li <?php echo (($page=='stk_skp' or $page=='stk_skp_detail')?'class="active"':''); ?>><a href="<?php echo base_url('publicpegawai/stk_skp') ?>">
                            <span class="mif-list icon"></span>
                            <span class="title">Riwayat SKP</span>
                        </a></li>
                    <li <?php echo (($page=='list_riwayat_cuti_jdwl_khusus')?'class="active"':''); ?>><a href="<?php echo base_url('publicpegawai/list_riwayat_cuti_jdwl_khusus') ?>">
                            <span class="mif-calendar icon"></span>
                            <span class="title">Cuti dan Jadwal Khusus</span>
                        </a></li>
                    <li <?php echo ($page=='download_data'?'class="active"':''); ?>><a href="<?php echo base_url('publicpegawai/download_data') ?>">
                            <span class="mif-download icon"></span>
                            <span class="title">Download Data</span>
                        </a></li>
                </ul>
            </aside>
            <div class="shifted-content h-700 p-ab">
                <div class="app-bar pos-absolute z-1 bg-grayMouse fg-white" data-role="appbar" style="border-bottom: 3px solid darkorange">
                    <button class="app-bar-item c-pointer" id="sidebar-toggle-3">
                        <span class="mif-menu fg-white"></span>
                    </button> <?php echo $title; ?>
                </div>
                <div class="h-700 p-4">
                    <?php
                    if(isset($view_type) == 'hmvc'){
                        echo $main_view;
                    }else{
                        $this->load->view($main_view);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <footer class="container-fluid bg-lightGray p-4" style="border-top: solid 1px rgba(71,71,72,0.35)">
        <div class="row">
            <div class="cell-md-6">
                <ul class="inline-list h-menu no-hover bg-lightGray" style="margin-left: -.5rem">
                    <li><a href="http://bkpsda.kotabogor.go.id//" target="_blank">BKPSDA</a></li>
                    <li><a href="http://simpeg.kotabogor.go.id" target="_blank">SIMPEG</a></li>
                </ul>
                <p>
                    Aplikasi e-Kinerja &copy; 2018 by SIMPEG Kota Bogor.
                    <br />
                    <span class="wrap">Badan Kepegawaian dan Pengembangan Sumberdaya Aparatur Kota Bogor </span>
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