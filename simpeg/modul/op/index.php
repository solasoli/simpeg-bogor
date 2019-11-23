<?php
session_start(); 
extract($_GET);
require_once("../../konek.php");
require_once "../../class/pegawai.php"; //nanti pindahkan ke global header ye..
require_once("../../class/unit_kerja.php");
require_once("../../library/format.php");


if(! isset($_SESSION['user']) && in_array(2, $_SESSION)) header('location: '.BASE_URL.'index.php');

print_r($_SESSION) ; 

$format = new Format;
$obj_pegawai = new Pegawai;
$pegawai = $obj_pegawai->get_obj($_SESSION['id_pegawai']);
	

?>
<!DOCTYPE html>
<html class="no-js">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<meta name="keywords" content="" />
	<meta name="description" content="Sistem Informasi Kepegawaian Pemerintah Kota Bogor">
	
	<title>SIMPEG::Dashboard</title>
	
	<link rel="shortcut icon" href="../../lib/img/pemkot_icon.jpg"/>		
	<link href="<?php echo BASE_URL ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">		
	<!--link href="<?php echo BASE_URL ?>assets/bootstrap/css/tabdrop.css" rel="stylesheet"-->		
	<link href="<?php echo BASE_URL ?>assets/bootstrap/css/costums.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>assets/DataTables/media/css/jquery.dataTables.css">
	<link href="<?php echo BASE_URL ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo BASE_URL ?>assets/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" />
	
	<script> var idp = <?php echo $pegawai->id_pegawai ?></script>
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
		<?php include("../global/global_header_menu.php") ?>		
	</div><!-- end of container header ya cuy -->
		
	<div class="container-fluid"><!-- start of content -->
		<div class="row">
		<div class="col-md-2 well ">
			<?php echo "samping" ?>
		</div>
		<div class="col-md-10 well">
			<?php
				
				if(isset($page)){
					include $page.".php";					
				}else{
					include ('home.php');
					
					
				}				
			?>
		</div>
		</div><!-- end of row -->
	</div><!-- end of div content -->
	
</div><!-- end of wrapper -->

	

</body>	
</html>
