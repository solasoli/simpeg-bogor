<? session_start(); 
extract($_POST);
extract($_GET);
require_once "konek.php";

if($_SESSION['user'] == NULL)
	{
		header('location:index.php');	
	}
 // test..
?>

<?php 
		require_once "konek.php";
		$q = mysqli_query($mysqli,"SELECT nama, id_pegawai FROM pegawai WHERE nip_lama = '$_SESSION[user]' OR nip_baru = '$_SESSION[user]'");
		if($r = mysqli_fetch_array($q))
			$user = $r[0]
			//echo $r[0]." | <a href='logout.php?id=".$r[1]."'>keluar</a>";			
?>
		
<!DOCTYPE html>
<html lang="en">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<meta name="keywords" content="" />
	<meta name="description" content="Sistem Informasi Kepegawaian Pemerintah Kota Bogor">
	
	<title>[SIMPEG] Kota Bogor</title>
	<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script language="javascript" src="js/jquery.min.js"></script>
	<script language="javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>	
	<script src="js/jquery.validate.js"></script>
	<script src="js/dropdown.js"></script>
	<script language="javascript" src="js/jquery-auco.js"></script>
	
	<!-- FLEXIGRID WIDGET -->
	<script language="javascript" src="js/flexigrid.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="css/flexigrid.pack.css" />
	
	<!-- CALENDAR WIDGET -->
	<link rel="stylesheet" type="text/css" href="tcal.css" />
	<script type="text/javascript" src="tcal.js"></script>
	
	<!-- The Templates plugin is included to render the upload/download listings -->
	<script src="js/JavaScript-Templates-2.2.1/js/tmpl.min.js"></script>
	<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
	<script src="js/JavaScript-Load-Image-1.7.3/js/load-image.min.js"></script>
	<!-- The Canvas to Blob plugin is included for image resizing functionality -->
	<script src="js/JavaScript-Canvas-to-Blob-master/js/canvas-to-blob.min.js"></script>
	<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
	<script src="js/bootstrap.min.js"></script>
	<script src="http://blueimp.github.com/Bootstrap-Image-Gallery/js/bootstrap-image-gallery.min.js"></script>
	<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
	<script src="js/jquery.iframe-transport.js"></script>
	<!-- The basic File Upload plugin -->
	<script src="js/jquery.fileupload.js"></script>
	<!-- The File Upload image processing plugin -->
	<script src="js/jquery.fileupload-ip.js"></script>
	<!-- The File Upload user interface plugin -->
	<script src="js/jquery.fileupload-ui.js"></script>
	<!-- The localization script -->
	<script src="js/locale.js"></script>
	<!-- The main application script -->
	<script src="js/main.js"></script>
	<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
	<!--[if gte IE 8]><script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->
	
	<link rel="stylesheet" href="http://blueimp.github.com/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css">
	<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
	<link rel="stylesheet" type="text/css" href="administrator/administrator.css">
	<!--<link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap.min.css">-->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.min.css">
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" />	
	<link href="css/excite-bike/jquery-ui-1.8.18.custom.css" rel="stylesheet" type="text/css" media="screen" />	
	<link rel="stylesheet" type="text/css" href="bootstrap/css/simpeg.css">
	
	
   
<?
/*
$x=$_REQUEST['x'];
if($x!='modchat.php')
{
	*/
?> 
 
<?
/*
}
*/
?>
<script> 
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-44687758-1', 'simpeg.org');
  ga('send', 'pageview');

</script>
</head>
<body >

<div id="wrapper">
<div class="container-fluid header">
	<div class="row">
		<div class="col-md-12">
			test haha
		</div>
	</div>
</div>
<!-- end header -->
<div id="page">
	<div id="content">
	
	