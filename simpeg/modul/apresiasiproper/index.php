<?php
session_start();
extract($_GET);
extract($_POST);
require_once("../../konek.php");
require_once "../../class/pegawai.php"; //nanti pindahkan ke global header ye..
require_once("../../class/unit_kerja.php");
require_once("../../library/format.php");
require "class.proper.php";

if(! isset($_SESSION['user'])) header('location: '.BASE_URL.'index.php');

$format = new Format;
$obj_pegawai = new Pegawai;
$proper = new Proper;
$peserta = $obj_pegawai->get_obj($_SESSION['id_pegawai']);
$unit_kerja = new Unit_kerja;
if(isset($_GET['idp'])){
	$theProper = $proper->get_proper_by_id(@$_GET['idp']);

	$mentor = $obj_pegawai->get_obj(@$theProper->id_mentor);
	$jabatan=@$pegawai->jabatan;


}else{

	$mentor = $proper->get_penilai($peserta);
}

?>


<!DOCTYPE html>
<html class="no-js">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="" />
	<meta name="description" content="Sistem Informasi Kepegawaian Pemerintah Kota Bogor">

	<title>Apresiasi Proyek Perubahan</title>

	<link rel="shortcut icon" href="../../lib/img/pemkot_icon.jpg"/>
	<link href="<?php echo BASE_URL ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">

	<link href="<?php echo BASE_URL ?>assets/bootstrap/css/costums.css" rel="stylesheet">
	<link rel="<?php echo BASE_URL ?>assets/DataTables/media/css/jquery.dataTables.css">
	<link href="<?php echo BASE_URL ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo BASE_URL ?>assets/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo BASE_URL ?>assets/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" />
	
	<link href="<?php echo BASE_URL ?>assets/breadcrumbs-and-multistep-indicator/css/style.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="skp.css">
	<script> var idp = <?php echo $pegawai->id_pegawai ?></script>
	<script src="<?php echo BASE_URL ?>js/jquery.min.js"></script>
	<script src="<?php echo BASE_URL ?>js/jquery.validate.js"></script>

	<script src="<?php echo BASE_URL ?>assets/bootstrap/js/bootstrap.js"></script>
	<script src="<?php echo BASE_URL ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo BASE_URL ?>assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.id.js"></script>

	<!-- FILE UPLOAD -->
	<script src="js/jquery.fileupload.js"></script>
	<!-- The File Upload image processing plugin -->
	<script src="js/jquery.fileupload-ip.js"></script>
	<!-- The File Upload user interface plugin -->
	<script src="js/jquery.fileupload-ui.js"></script>

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

			if(!isset($_GET['act']) == 'print' ){
				include("header_menu.php");
			}

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

					switch($page){
						// ini oleh pegawai ybs pada awal masa penilaian
						case "proper":
							include "home.php";
							break;
						case "monitor_proper":
								include "home_monitoring.php";
								break;
						case "mentor":
								include "mentoring.php";
								break;
						case "mentor_monitor":
								include "mentor_monitor.php";
								break;
						case "listofskpt_old":
							include "skp_target_list.php";
							break;
						case "listofskp":
							include "skp_target_list.php";
							break;
							case "monitoring":
							include "ubah_data2.php";
							break;
						case "formulir" :
							include "skp_target_form.php";
							break;
						case "formulir_v2" :
							include "skp_target_form_v2.php";
							break;
						case "listofrealisasi":
							include "skp_realisasi_list.php";
							break;
						case "realisasi":
							include "skp_realisasi_form.php";
							break;
						case "listofgabungan":
							include "gabungan_list.php";
							break;
						case "gabungan":
							include "gabungan_form.php";
							break;
						case "listofmyperilaku":
							include "my_perilaku_list.php";
							break;
						case "myperilaku":
							include "my_perilaku.php";
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
						case "data":
							include "ubah_data_list.php";
							break;
						case "ubah_data":
							include "ubah_data.php";
							break;
						case "cover":
							include "cover.php";
							break;
						case "data_skp":
							include "data_skp.php";
							break;
						case "data_tgl":
							include "tgl.php";
							break;
						case "statistik":
							include "statistik.php";
							break;
							case "statistik2":
							include "statistik2.php";
							break;

						case "statistik3":
							include "statistik_status.php";
							break;

						case "list":
							include "list.php";
							break;
						case "listtabel":
							include "listtabel.php";
							break;
						case "pg":
							include "perilaku_gabungan.php";
							break;
						//percobaan skp dibuat dalam tab-tab
						case "form":
							include "form.php";
							break;

						case "unggah":
							include "unggah.php";
							break;
						//export excel
						case "review_target_xlsx":
							include "skp_review_form_xlsx.php";
							break;
						case "rekap":
							include "rekap_skp.php";
							break;
						default :
							echo "<h1>404 page not found !!</h1>";
					}
				}else{


					include "list.php";


				}
			?>
		</div>
		<!--/div><!-- end of row -->
	</div><!-- end of div content -->

</div><!-- end of wrapper -->

	<script src="<?php echo BASE_URL ?>assets/jquery-ui/jquery-ui.min.js"></script>

</body>
</html>
