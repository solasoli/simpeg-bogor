<?php
session_start();
if(!isset($_SESSION['id_pegawai']) ){
	header('location:index.php');

}
/*
header('Access-Control-Allow-Origin: http://simpeg.dev.kotabogor.net/');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
*/
//echo $_SESSION['id_pegawai'];
extract($_POST);
extract($_GET);

require_once "konek.php";
//require_once("util.php");
require_once("class/unit_kerja.php");
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="" />
	<meta name="description" content="Sistem Informasi Kepegawaian Pemerintah Kota Bogor">

	<title>[SIMPEG] Kota Bogor</title>

	<link rel="shortcut icon" href="lib/img/pemkot_icon.jpg"/>
	<link rel="stylesheet" type="text/css" href="assets/css/simpeg.css">
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" >
	<link rel="stylesheet" href="assets/bootstrap/css/tabdrop.css" >
	<link rel="stylesheet" href="assets/bootstrap-datepicker/css/datepicker3.css">
	<link href="assets/sweetalert/dist/sweetalert.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/bootstrap/css/costums.css" >


	<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
	<!--link rel="stylesheet" href="assets/DataTables/media/css/jquery.dataTables.css"-->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<!--link rel="stylesheet" href="css/dataTables.tableTools.css" type="text/css"-->
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" type="text/css">
	<!--link rel="stylesheet" href="css/jquery-ui.css"-->
	<!--[if lte IE 9]>
		  <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
		  <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js"></script>
	<![endif]-->
	<!--script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script-->
	<script src="js/jquery.min.js"></script>
	<script language="javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
	<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js "></script>
	<script src="js/jquery.validate.js"></script>
	<script src="assets/bootstrap/js/bootstrap.js"></script>

	<script src="assets/bootstrap/js/bootstrap-tabdrop.js"></script>

	<!-- The Templates plugin is included to render the upload/download listings -->
	<script src="js/JavaScript-Templates-2.2.1/js/tmpl.min.js"></script>
	<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
	<script src="js/JavaScript-Load-Image-1.7.3/js/load-image.min.js"></script>

	<!-- CALENDAR WIDGET -->
	<link rel="stylesheet" type="text/css" href="tcal.css" />
	<script type="text/javascript" src="tcal.js"></script>

	<!-- FILE UPLOAD -->
	<script src="js/jquery.fileupload.js"></script>
	<!-- The File Upload image processing plugin -->
	<script src="js/jquery.fileupload-ip.js"></script>
	<!-- The File Upload user interface plugin -->
	<script src="js/jquery.fileupload-ui.js"></script>
	<!-- The localization script -->
	<script src="js/locale.js"></script>
	<!-- The main application script -->
	<script src="js/main.js"></script>
	<script src="assets/sweetalert/dist/sweetalert.min.js"></script>
	<script src="http://simpeg.kotabogor.net/simpeg/assets/js/moment.js"></script>
	<script src="http://simpeg.kotabogor.net/simpeg/assets/js/moment_langs.js"></script>
	<script src="http://simpeg.kotabogor.net/simpeg/assets/js/combodate.js"></script>

	<link rel="stylesheet" href="assets/css/jquery.fileupload.css">
	<link href="http://simpeg.kotabogor.net/simpeg/assets/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" >

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-44687758-1', 'simpeg.kotabogor.go.id');
  ga('send', 'pageview');

</script>

</head>
<body >
<div id="wrapper">

 <!-- navbar here -->
	<?php include("modul/global/global_header_menu.php") ?>
<!-- end of navbar -->



<?php // print_r($_SESSION) ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 hidden-print">
			<!--marquee scrollamount="5" BEHAVIOR=ALTERNATE>
					<p><strong>newsflash :</strong>

					<a href="./downloads/sipujangga.pdf" target="_blank">
					Manual Penggunaan Layanan Online Perubahan Tunjangan Keluarga
					</a>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <a href="./downloads/cuti.pdf" target="_blank">
					Manual Penggunaan Layanan Online Cuti
					</a>

                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <a href="./downloads/panduan_skp_v0.1.pdf" target="_blank">
					Manual Penggunaan Layanan Online SKP
					</a>
				</p>
			</marquee-->
		</div>
	</div>
	<div class="row">
		<!-- side bar here -->

		<div class="col-md-3 hidden-print">
			<?php

				if($_SESSION['id_pegawai'] == 11301){
					include 'sidebar.php';
				}else{
					include 'sidebar.php';
				}

			?>
		</div>

		<!-- end sidebar my bro -->

		<!-- content strat here -->

		<div class="col-md-9">

			<?php

				/*if($x==NULL){
					include("home.php");
				*/
				if(isset($x)){
					include("$x");
				}elseif(isset($p)){

					switch ($p) {

						/*case "box" :
							include "box.php";
							break;*/
						case "download" :
							include ("modul/page/download.php");
							break;
						case "organigram" :
							include "modul/organigram.php";
							break;
						case "kslist":
							require_once "class/unit_kerja.php";
							include "modul/laporan/kepsek.php";
							break;
						case "proper":
							include "proper.php";
							break;
						default :
							include "home.php";
					}
				}else{
					include("home.php");
				}


			?>
		</div>
		<!-- end content -->
	</div>

</div><!-- end of container -->


	<!--div class="container-fluid footer" id="footer">
		<div class="row-fluid" >
			<div class="col-xs-12">
				<label>BKPP Pemerintah Kota Bogor</label><br>
				<label>Jl.Ir.H. Juanda No 10, Kota Bogor</label><br>
				<label>Telp. 02518356170 - Ext. 225</label><br>
				<label>Email: simpeg.kotabogor@gmail.com</label><br>
				<label>Copyright &copy 2009 - <?php echo date('Y') ?> </label>
			</div>
		</div>
	</div-->



</div>


	<script src="assets/plugins/totop/easing.js" type="text/javascript"></script>
	<script type="text/javascript" src="assets/plugins/totop/jquery.ui.totop.min.js"></script>
	<!--script src="assets/DataTables/media/js/jquery.dataTables.js" type="text/javascript"></script-->
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="	https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js" type="text/javascript"></script>
	<script src="	https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js" type="text/javascript"></script>
	<script src="	https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
	<script src="	https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js" type="text/javascript"></script>
	<script src="	https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js" type="text/javascript"></script>
	<script src="	https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js" type="text/javascript"></script>
	<script src="	https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js" type="text/javascript"></script>

	<script src="assets/DataTables/media/js/dataTables.buttons.min.js" type="text/javascript"></script>
	<!--script src="js/dataTables.tableTools.min.js" type="text/javascript"></script-->
	<script src="assets/js/modernizr.custom.80028.js" type="text/javascript"></script>
	<script src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

	<script type="text/javascript">
		$(window).bind('scroll', function() {
			 if ($(window).scrollTop() > 50) {
				 $('.navbar').addClass('navbar-fixed-top');
			 }
			 else {
				 $('.navbar').removeClass('navbar-fixed-top');
			 }
		});
		$(document).ready(function() {
			/*$('.nav-tabs').tabdrop();*/
			$().UItoTop({ easingType: 'easeOutQuart' });
		});
	</script>

	 <script>
	 $(document).ready(function() {
		$("#menu-toggle").click(function(e) {
			e.preventDefault();
			$("#wrapper").toggleClass("active");
		});

         <!--Start of Tawk.to Script-->

         var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
         (function(){
             var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
             s1.async=true;
             s1.src='https://embed.tawk.to/5acacc14d7591465c7094d55/default';
             s1.charset='UTF-8';
             s1.setAttribute('crossorigin','*');
             s0.parentNode.insertBefore(s1,s0);
         })();

        <!--End of Tawk.to Script-->

	});

    </script>

</body>
</html>
