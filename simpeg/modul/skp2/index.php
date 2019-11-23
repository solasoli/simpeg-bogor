<?php
session_start(); 
extract($_GET);
require_once("../../konek.php");
require_once "../../class/pegawai.php"; //nanti pindahkan ke global header ye..
require_once("../../class/unit_kerja.php");
require_once("../../library/format.php");
require "skp.php";

if(! isset($_SESSION['user'])) header('location: '.BASE_URL.'index.php');

$format = new Format;
$obj_pegawai = new Pegawai;
$skp = new Skp;
$pegawai = $obj_pegawai->get_obj($_SESSION['id_pegawai']);	
$unit_kerja = new Unit_kerja;
if(! isset($_GET['idskp'])){
	
	$penilai = $skp->get_penilai($pegawai);
	$atasan_penilai = $skp->get_penilai($penilai);
}else{
	$ppk = $skp->get_skp_by_id($_GET['idskp']);
		
	
	$penilai = $obj_pegawai->get_obj($ppk->id_penilai);
	$atasan_penilai = $skp->get_penilai($penilai);
	
	
	$theSkp = $skp->get_skp_by_id($_GET['idskp']) ;
}
	
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
		<div class="col-md-2 ">
			<?php include('skp_sidebar.php') ?>
		</div>
		<div class="col-md-10" id="skp_content">
			<?php
				
				if(isset($page)){
					
					switch($page){
						// ini oleh pegawai ybs pada awal masa penilaian
						case "listofskp":
							include "skp_target_list.php";
							break;
						case "formulir" :  
							include "skp_target_form.php";
							break;
						case "listofrealisasi":
							include "skp_realisasi_list.php";
							break;
						case "realisasi":
							include "skp_realisasi_form.php";
							break;												
						case "review":
							include "skp_review_form.php";
							break;												
						case "pengukuran";
							include "skp_pengukuran_form.php";
							break;	
						case "reviewrealisasi":
							include "skp_review_realisasi_form.php";
							break;						
						case "listofsubordinate":
							include "skp_subordinate_list.php";
							break;	
						case "los":
							include "skp_subskp_list.php";
							break;
						case "los2":
							include "skp_laporan_list.php";
							break;
						case "perilaku":
							include "skp_perilaku_form.php";
							break;
						case "final":
							include "skp_final_form.php";
							break;
						case "final2":
							include "skp_final_form2.php";
							break;
						case "monitoring":
							include "monitoring_skp_list.php";
							break;
						case "pengaturan":
							include "pengaturan_skp.php";
							break;
						default :
							echo "<h1>page not found !!</h1>";
					}
				}else{
					include ('skp_home.php');
					
					
				}				
			?>
		</div>
		</div><!-- end of row -->
	</div><!-- end of div content -->
	
</div><!-- end of wrapper -->

	<script src="<?php echo BASE_URL ?>assets/jquery-ui/jquery-ui.min.js"></script>

</body>	
</html>
