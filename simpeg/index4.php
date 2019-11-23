<?php 
session_start();

//print_r($_SESSION);
/*
if(!$_SESSION['id_pegawai']){
	header('location:index.php');	
}
 */
extract($_POST);
extract($_GET);

require_once "konek.php";
require_once("util.php");
require_once("class/unit_kerja.php");
?>
		
<!DOCTYPE html>
<html lang="en">
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
	<link rel="stylesheet" href="assets/bootstrap/css/costums.css" >
	
		
	<link rel="stylesheet" href="css/jquery.fileupload-ui.css">	
	<link rel="stylesheet" href="assets/DataTables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" href="css/dataTables.tableTools.css" type="text/css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<!--[if lte IE 9]>
		  <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
		  <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js"></script>
	<![endif]--> 
	<!--script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script-->
	<script src="js/jquery.min.js"></script>
	<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js "></script>
	<script src="js/jquery.validate.js"></script>
	<script src="assets/bootstrap/js/bootstrap.js"></script>
	<script language="javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>	
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
	
	<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
	<link rel="stylesheet" href="assets/css/jquery.fileupload.css">
	
	<link rel="stylesheet" href="css/jquery-ui-1.8.18.custom.css">
<script> 
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-44687758-1', 'simpeg.kotabogor.org');
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
			<marquee scrollamount="3">
					<p><strong>newsflash :</strong>
					<span>Alamat alternatif simpeg : <a href="http://36.66.76.147/simpeg" target="_blank">http://36.66.76.147/simpeg</a></span>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
					<a href="./downloads/formasi.pdf" target="_blank"> 
					Pemberitahuan Penyampaian Kebutuhan Pegawai ASN melalui sistem e-Formasi dapat didownload 
					disini</a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
				
					<a href="./downloads/~pupns/tindak_lanjut_PUPNS.pdf" target="_blank"> 
					Surat Edaran Sekretaris Daerah Kota Bogor Nomor 800/90 tentang Tindak Lanjut PUPNS tanggal 11 Januari 2016 
					</a>
				</p>
			</marquee>
		</div>
	</div>
	<div class="row">
		<!-- side bar here -->
		<div class="col-md-2 hidden-print">
			<?php 							
				//include 'sidebar3.php'; 				
			?>
		</div>
		<!-- end sidebar my bro -->
		
		<!-- content strat here -->
		<div class="col-md-10">
			<?php
			
				/*if($x==NULL){				
					include("home.php");	
				*/
				if(isset($x)){
					include("$x");
				}elseif(isset($p)){
					
					switch ($p) {
					
						case "box" :
							include "box.php";
							break;
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


	<div class="container-fluid footer" id="footer">
		<div class="row-fluid" >
			<div class="col-xs-12">
				<label>BKPP Pemerintah Kota Bogor</label><br>
				<label>Jl.Ir.H. Juanda No 10, Kota Bogor</label><br>
				<label>Telp. 02518356170 - Ext. 225</label><br>
				<label>Email: simpeg.kotabogor@gmail.com</label><br>
				<label>Copyright &copy 2009 - <?php echo date('Y') ?> </label>
			</div>
		</div>	
	</div>



</div>
	
	
	<script src="assets/plugins/totop/easing.js" type="text/javascript"></script>
	<script type="text/javascript" src="assets/plugins/totop/jquery.ui.totop.min.js"></script>
	<script src="assets/DataTables/media/js/jquery.dataTables.js" type="text/javascript"></script>
	<script src="js/dataTables.tableTools.min.js" type="text/javascript"></script>
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
	});
    </script>
	
</body>
</html>
