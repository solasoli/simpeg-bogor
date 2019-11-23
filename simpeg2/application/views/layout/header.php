<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php  $this->session->userdata('user') ? $user = $this->session->userdata('user'):redirect('login','refresh'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="shortcut icon" href="images/favicon.ico">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ADMINISTRATOR SIMPEG Kota Bogor</title>


	<link rel="stylesheet" href="<?php echo base_url()?>assets/metro/css/metro-bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/metro/css/metro-bootstrap-responsive.css" >
    <link rel="stylesheet" href="<?php echo base_url()?>css/chosen.css">
	<link rel="stylesheet" href="<?php echo base_url()?>css/chosen-bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">
	<link rel="stylesheet" href="<?php echo base_url()?>css/jqueryui/jquery-ui.min.css">

	<!-- JS Library -->
	<script src="<?php echo base_url()?>js/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url()?>js/jquery/jquery.widget.min.js"></script>
	<script src="<?php echo base_url()?>js/jquery/jquery.dataTables.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/tabletools/2.2.4/css/dataTables.tableTools.css" type="text/css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" type="text/css">

	<script src="<?php echo base_url()?>js/jquery/jquery.autocomplete.js"></script>
	<script src="<?php echo base_url()?>js/jquery/jquery-ui.js"></script>
    <script src="<?php echo base_url()?>assets/metro/min/metro.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/assets/moment.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>js/assets/moment_langs.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/combodate.js"></script>
	<!--script src="<?php //echo base_url()?>js/jquery/jquery.mousewheel.js"></script-->

	<!-- Metro UI CSS JavaScript plugins -->
    <!--script src="<?php //echo base_url()?>js/load-metro.js"></script-->

</head>
<body class="metro" >
<!--div class="page"-->
	<div class="navbar hidden-print">
		<div class="navbar-content">
			<a href="<?php echo base_url('home/dashboard')?>" class="element"><span class="icon-home"></span> ADMINSIMPEG <sub>2.0</sub></a>
            <span class="element-divider"></span>

			<a class="pull-menu" href="#"></a>
			<ul class="element-menu">
				<li>
					<?php echo anchor("#", "Master",array("class"=>"dropdown-toggle")); ?>
				  <ul class="dropdown-menu" data-role="dropdown">
						<li><?php echo anchor("master/role_function", "Roles Function") ?></li>
						<li><?php echo anchor("master/function_list", "App Function") ?></li>
						<li><?php echo anchor("master/user_roles", "User's roles") ?></li>
						<li>
							<?php echo anchor("#", "Jabatan",array("class"=>"dropdown-toggle")); ?>
							<ul class="dropdown-menu" data-role="dropdown">
								<li><?php echo anchor("#", "Struktural") ?></li>
								<li><?php echo anchor("#", "JFT") ?></li>
								<li><?php echo anchor("jabatan/jfu_list", "JFU") ?></li>
							</ul>
						</li>
						<li><?php echo anchor("unit_kerja/daftar", "Unit Kerja") ?></li>
					</ul>
				</li>
				<li><?php echo anchor("hukuman_disiplin", "Hukuman Disiplin"); ?></li>
				<!--<li><?php //echo anchor("cuti", "Cuti"); ?></li>-->
                <li><?php echo anchor("cuti_pegawai", "Cuti Pegawai"); ?></li>
				<li>
					<?php echo anchor("#", "Mutasi", array("class"=>"dropdown-toggle")); ?>
				  <ul class="dropdown-menu" data-role="dropdown">
						<li><?php echo anchor("kgb","KGB")?></li>
						<li><?php echo anchor("pencantuman_gelar","Pencantuman Gelar")?></li>
					</ul>
				</li>

                <li>
					<?php echo anchor("#", "Pengembangan Karier", array("class"=>"dropdown-toggle")); ?>
				  <ul class="dropdown-menu" data-role="dropdown">
                  	<li><?php echo anchor("ipasn","Indeks Profesionalitas ASN")?></li>
						<li><?php echo anchor("ib","Ijin Belajar")?></li>
						<li><?php echo anchor("ib/pengajuan","Rekap Pengajuan Ijin Belajar")?></li>
						<li><?php echo anchor("ib/setuju","Rekap Ijin Belajar yang Disetujui")?></li>
						<li><?php echo anchor("ib/daftar","Rekap Penerbitan Ijin Belajar")?></li>
                        <li><?php echo anchor("ib/tutorial","Tutorial Ijin Belajar Online")?></li>
                         <li><?php echo anchor("ib/alur","Alur Ijin Belajar Online")?></li>
					</ul>
				</li>

				<li><?php echo anchor("alih_tugas", "Alih Tugas"); ?></li>
				<li>
					<?php echo anchor("#", "Inpassing", array("class"=>"dropdown-toggle")); ?>
				  <ul class="dropdown-menu" data-role="dropdown">
						<li><?php echo anchor("inpassing/gaji","Inpassing Gaji")?></li>
						<li><?php echo anchor("inpassing/jfu","Inpassing Jabatan")?></li>
					</ul>
				</li>

				<li>
					<?php echo anchor("#", "Jabatan Struktural",array("class"=>"dropdown-toggle")); ?>
				  <ul class="dropdown-menu" data-role="dropdown">
						<li><?php echo anchor("jabatan_struktural","Rekapitulasi")?></li>
						<li><?php echo anchor("jabatan_struktural/nominatif_riwayat","Nominatif Riwayat")?></li>
						<li><?php echo anchor("jabatan_struktural/draft_pelantikan","Anjas Go Clear")?></li>
                        <li><?php echo anchor("datatablestruktural","Daftar Pejabat Struktural")?></li>
						<li><?php echo anchor("jabatan_struktural/pengaturan","Pengaturan Baperjakat")?></li>
                        <li><?php echo anchor("jabatan_struktural/list_jabatan_plt","Jabatan PLT dan PLH")?></li>
                        <li><?php echo anchor("jabatan_struktural/list_open_bidding","Open Bidding")?></li>
					</ul>
				</li>

				<li>
					<?php echo anchor("#", "Lainnya", array("class"=>"dropdown-toggle")); ?>
				  <ul class="dropdown-menu" data-role="dropdown">
						<li><?php echo anchor("pegawai/report_jumlah_transit","Laporan Jumlah Transrit Kendaraan Pegawai")?></li>
						<li><?php echo anchor("pencantuman_gelar","Pencantuman Gelar")?></li>
						<li><?php echo anchor("perubahan_keluarga","Perubahan Keluarga")?></li>
                        <li><?php echo anchor("request_data","Permintaan Data")?></li>
					</ul>
				</li>
			</ul>



			<div class="element place-right">
				<a class="dropdown-toggle" href="#">
					<span class="icon-cog"></span>
					<?php echo $this->session->userdata('user')->nama ?>
				</a>
              <ul class="dropdown-menu place-right" data-role="dropdown">
					<li><a href="#">Ubah Pasword</a></li>
                    <li><?php echo anchor("user/logout","logout")?></li>
                </ul>
            </div>


		</div>
	</div>
<!--/div-->
