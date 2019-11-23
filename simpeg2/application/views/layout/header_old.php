<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!$this->session->userdata('user')){
	redirect('');
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>	
	<link rel="shortcut icon" href="images/favicon.ico">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SIMPEG 2013 Kota Bogor</title>

	<link href="<?php echo base_url(); ?>css/modern.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/modern-responsive.css" rel="stylesheet">   
	<link href="<?php echo base_url(); ?>css/site.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="<?php echo base_url();?>js/assets/jquery-1.9.0.min.js" ></script>
	<link href="<?php echo base_url(); ?>css/jqueryui/jquery-ui.min.css" rel="stylesheet">   	
	
	
	<script type="text/javascript" src="<?php echo base_url();?>js/assets/jquery.mousewheel.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/assets/moment.js"></script>	
    <script type="text/javascript" src="<?php echo base_url();?>js/assets/moment_langs.js"></script>
	
	<!--<script type="text/javascript" src="https://www.google.com/jsapi"></script>-->
    <script type="text/javascript" src="<?php echo base_url();?>js/modern/dropdown.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/modern/accordion.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/modern/buttonset.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/modern/carousel.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/modern/input-control.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/modern/pagecontrol.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/modern/rating.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/modern/slider.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/modern/tile-slider.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/modern/tile-drag.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/modern/calendar.js"></script>
    
</head>
<body class="metrouicss" >
<div class="page">
	<div class="nav-bar">
		<div class="nav-bar-inner padding10">
			<span class="pull-menu"></span>

			<a href="<?php echo base_url(); ?>"><span class="element brand">				
				SIMPEG
			</span></a>
			<div class="divider"></div>	
			<ul class="menu">
				<li><?php echo anchor("hukuman_disiplin", "Hukuman Disiplin"); ?></li>	
				<li><?php echo anchor("cuti", "Cuti"); ?></li>	
				<li><?php echo anchor("kgb", "KGB"); ?></li>
				<li><?php echo anchor("master", "Master"); ?></li>
				<li><?php echo anchor("inpassing", "Inpassing"); ?></li>
			</ul>
			<ul class="menu">
				<li><?php echo anchor("user/logout", "Logout (".$this->session->userdata('user')->nama_pendek.")"); ?></li>							
			</ul>
		</div>
	</div>
</div>


<div class="page secondary <!--with-sidebar-->">
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
