<?php
session_start();
 
require_once("../konek.php");
//require_once "../../class/duk.php";
require_once "../class/unit_kerja.php";
require_once("../library/format.php");

if(! isset($_SESSION['id_pegawai'])) header('location: '.BASE_URL.'index.php');


?>

<!DOCTYPE html>
<html class="no-js">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<meta name="keywords" content="" />
	<meta name="description" content="Sistem Informasi Kepegawaian Pemerintah Kota Bogor">
	
	<title>Dashboard::SIMPEG</title>
	
	<link rel="shortcut icon" href="../../lib/img/pemkot_icon.jpg"/>		
	<link href="<?php echo BASE_URL ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">		
	<!--link href="<?php echo BASE_URL ?>assets/bootstrap/css/tabdrop.css" rel="stylesheet"-->		
	<link href="<?php echo BASE_URL ?>assets/bootstrap/css/costums.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>assets/DataTables/media/css/jquery.dataTables.css">
	<link href="<?php echo BASE_URL ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo BASE_URL ?>assets/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo BASE_URL ?>assets/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" />
		
	<script src="<?php echo BASE_URL ?>js/jquery.min.js"></script>
	<script src="<?php echo BASE_URL ?>js/jquery.validate.js"></script>
	
	<script src="<?php echo BASE_URL ?>assets/bootstrap/js/bootstrap.js"></script>
	<script src="<?php echo BASE_URL ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo BASE_URL ?>assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.id.js"></script>	
	
	
	<!--script src="<?php echo BASE_URL ?>assets/bootstrap/js/bootstrap-tabdrop.js"></script-->
	<script type="text/javascript" src="<?php echo BASE_URL ?>js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL ?>js/modernizr.js"></script>	
	<style>
		.datepicker{z-index:1151 !important;}
	</style>
</head>
<body>

<div id="wrapper">
	<!-- container header start here -->
	<div class="hidden-print">
		<?php include("../modul/global/global_header_menu.php") ?>		
	</div><!-- end of container header ya cuy -->
		
	<div class="container-fluid"><!-- start of content -->		
		<div class="row container col-md-12">
			<!--div class="col-md-3" id="pilter"-->
				<!--sidebar menu-->
				<?php //include "sidebar.php" ?>
				<!-- end of sidebar menu -->
			<!-- /div -->
			<div class="col-md-9" id="regenerate">
				<div class="row">
					<?php
						if($_GET['page']){
							include($_GET['page']).".php";
						}else{
							include('dashboard.php');
						}						
					?>					
				</div>
			</div>
		</div>
		<div class="row">		
		<div class="col-md-12 table-responsive" id="content">
			<?php //print_r($_SESSION) ?>
		</div>
		</div><!-- end of row -->
	</div><!-- end of div content -->
	
</div><!-- end of wrapper -->

	<script src="<?php echo BASE_URL ?>assets/jquery-ui/jquery-ui.min.js"></script>

</body>	
</html>
