<?php 
session_start(); 
extract($_GET);
require_once("../../konek.php");
require_once "../../class/pegawai.php"; //nanti pindahkan ke global header ye..
require_once("../../class/unit_kerja.php");
require_once("../../library/format.php");

?>
<!DOCTYPE html>
<html class="no-js">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<meta name="keywords" content="" />
	<meta name="description" content="Sistem Informasi Kepegawaian Pemerintah Kota Bogor">
	
	<title>SKP</title>
	
	<link rel="shortcut icon" href="../../lib/img/pemkot_icon.jpg"/>		
	<link href="<?php echo BASE_URL ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">		
	<!--link href="<?php echo BASE_URL ?>assets/bootstrap/css/tabdrop.css" rel="stylesheet"-->		
	<link href="<?php echo BASE_URL ?>assets/bootstrap/css/costums.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>assets/DataTables/media/css/jquery.dataTables.css">
	<link href="<?php echo BASE_URL ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo BASE_URL ?>assets/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo BASE_URL ?>assets/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" />
	
	<link rel="stylesheet" href="skp.css">
	<script> var idp = <?php echo $pegawai->id_pegawai ?></script>
	<script src="<?php echo BASE_URL ?>js/jquery.min.js"></script>
	<script src="<?php echo BASE_URL ?>js/jquery.validate.js"></script>
	
	<script src="<?php echo BASE_URL ?>assets/bootstrap/js/bootstrap.js"></script>
	<script src="<?php echo BASE_URL ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo BASE_URL ?>assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.id.js"></script>	
	
	<script src="<?php echo BASE_URL ?>assets/js/moment.js"></script>
	<script src="<?php echo BASE_URL ?>assets/js/moment_langs.js"></script>
	<script src="<?php echo BASE_URL ?>assets/js/combodate.js"></script>
	
	
	<!--script src="<?php echo BASE_URL ?>assets/bootstrap/js/bootstrap-tabdrop.js"></script-->
	<script type="text/javascript" src="<?php echo BASE_URL ?>js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL ?>js/modernizr.js"></script>
	<!--script language="javascript" src="<?php echo BASE_URL ?>js/jquery-ui-1.8.18.custom.min.js"></script-->		
	<style>
		.datepicker{z-index:1151 !important;}
	</style>
</head>
<body>

<div id="wrapper">
	<!-- container header start here -->
	<div class="hidden-print">
		<?php 
			
			include("header_menu.php");
			
		?>		
	</div><!-- end of container header ya cuy -->
		
	<div class="container-fluid"><!-- start of content -->
		<!--div class="row"-->
		<!--div class="col-md-2">
			<?php //include('skp_sidebar.php') ?>
		</div-->
		<div class="col-md-12" id="skp_content">
			<?php
				
				if(isset($page)){
					
					include $page."php";
				}else{
					include ('home.php');
					
					
				}				
			?>
		</div>
		<!--/div><!-- end of row -->
	</div><!-- end of div content -->
	
</div><!-- end of wrapper -->

	<script src="<?php echo BASE_URL ?>assets/jquery-ui/jquery-ui.min.js"></script>

</body>	
</html>