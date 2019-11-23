<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php  $this->session->userdata('user')? $user = $this->session->userdata('user'):redirect('home/login','refresh');?>

<?php
/*if(!$this->session->userdata('user')){
	redirect('');
} */
//echo "data session :";
//print_r ($this->session->userdata('user'));


?>
<!DOCTYPE html>
<html lang="en">
<head>	
	<link rel="shortcut icon" href="images/favicon.ico">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SIMPEG 2013 Kota Bogor</title>
	
	<link rel="stylesheet" href="<?php echo base_url()?>assets/metro/css/metro-bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/metro/css/metro-bootstrap-responsive.css" >
    
	<!-- JS Library -->
	<script src="<?php echo base_url()?>js/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url()?>js/jquery/jquery.widget.min.js"></script>
    <script src="<?php echo base_url()?>assets/metro/min/metro.min.js"></script>
	<!--script src="<?php //echo base_url()?>js/jquery/jquery.mousewheel.js"></script-->
	
	<!-- Metro UI CSS JavaScript plugins -->
    <!--script src="<?php //echo base_url()?>js/load-metro.js"></script-->
	
	
    
</head>
<body class="metro" >
<!--div class="page"-->
	<div class="navbar">
		<div class="navbar-content">
			<a href="<?php echo base_url('home')?>" class="element"><span class="icon-arrow-left-3"></span> SIMPEG <sub>2.0</sub></a>
            <span class="element-divider"></span>

			<a class="pull-menu" href="#"></a>
			<ul class="element-menu">
				<li><?php echo anchor("hukuman_disiplin", "Hukuman Disiplin"); ?></li>				
				<li><?php echo anchor("cuti", "Cuti"); ?></li>				
				<li><?php echo anchor("kgb", "KGB"); ?></li>				
				<li>
					<?php echo anchor("#", "Master",array("class"=>"dropdown-toggle")); ?>
					<ul class="dropdown-menu" data-role="dropdown">
						<li><?php echo anchor("master/roles", "Roles")?></li>
						<li><?php echo anchor("master/role_function", "Roles Function") ?></li>
						<li><?php echo anchor("master/app_function", "App Function") ?></li>
						<li><?php echo anchor("master/user_roles", "User's roles") ?></li>
					</ul>
				</li>				
				<li><?php echo anchor("inpassing","Inpassing Gaji")?></li>
			</ul>
			
			<div class="element place-right">
				<a class="dropdown-toggle" href="#">
					<span class="icon-cog"></span>
					<?php echo $this->session->userdata('user')->nama_pendek ?>
				</a>
                <ul class="dropdown-menu place-right" data-role="dropdown">
					<li><a href="#">Ubah Pasword</a></li>
                    <li><?php echo anchor("user/logout","logout")?></li>
                </ul>
            </div>
			
				
		</div>
	</div>
<!--/div-->


<!--div class="page secondary " ><!--with-sidebar-->
	<!--
	<div class="page-sidebar">
		<ul>
			<li><?php //echo anchor("welcome/home", "Panel Utama") ?></li>						
			<li><?php //echo anchor("report", "Laporan & Statistik") ?></li>						
			<li class="sticker sticker-color-orange dropdown" data-role="dropdown">
				<a><i class="icon-list"></i> Pelamar</a>
				<ul class="sub-menu light sidebar-dropdown-menu">
					<li><?php //echo anchor("pelamar", "Cari pelamar"); ?></li>
					<li><?php //echo anchor("pelamar/form", "Entri MS"); ?></li>
					<li><?php //echo anchor("pelamar/form_tms", "Entri TMS"); ?></li>
					<li><?php //echo anchor("", "TKK Kat.2"); ?></li>
					<li><?php //echo anchor("", "Nominatif"); ?></li>
				</ul>
			</li>
			<li class="sticker sticker-color-pink dropdown" data-role="dropdown">
				<a><i class="icon-list"></i> Print</a>
				<ul class="sub-menu light sidebar-dropdown-menu">
					<li><?php //echo anchor("", "Kartu Peserta"); ?></li>
					<li><?php //echo anchor("", "Absensi Kelas"); ?></li>
					<li><?php //echo anchor("", "Daftar Peserta"); ?></li>
				</ul>
			</li>
			<li class="sticker sticker-color-red dropdown" data-role="dropdown">
				<a><i class="icon-list"></i> Data Master</a>
				<ul class="sub-menu light sidebar-dropdown-menu">
					<li><?php //echo anchor("kategori_penerimaan", "Kategori Penerimaan"); ?></li>
					<li><?php //echo anchor("jenis_jabatan", "Jenis Jabatan"); ?></li>
				</ul>
			</li>
			<li class="sticker sticker-color-green dropdown" data-role="dropdown">
				<a><i class="icon-list"></i> Pengaturan</a>
				<ul class="sub-menu light sidebar-dropdown-menu">
					<li><?php //echo anchor("formasi", "Formasi"); ?></li>	
					<li><?php //echo anchor("", "Ruang Ujian"); ?></li>						
					<li><?php //echo anchor("persyaratan", "Persyaratan"); ?></li>						
				</ul>
			</li>
			<li class="sticker sticker-color-yellow dropdown" data-role="dropdown">
				<a><i class="icon-list"></i> Control Panel</a>
				<ul class="sub-menu light sidebar-dropdown-menu">
					<li><?php //echo anchor("", "User"); ?></li>						
					<li><?php //echo anchor("", "Menu"); ?></li>						
				</ul>
			</li>			
		</ul>
	</div>
	-->

	<!--<div class="page-region">
		<div class="page-region-content">	-->
