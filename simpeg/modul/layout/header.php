<?php 
session_start(); 
extract($_POST);
extract($_GET);

require_once "../../konek.php";
require_once("../../util.php");

$is_tim = false; // tim opd flag 
$is_administrator = false; //admin flag
if($_SESSION['user'] == NULL)
	{
		header('location:index.php');	
	}

	$q = mysql_query("SELECT * FROM pegawai WHERE nip_lama = '$_SESSION[user]' OR nip_baru = '$_SESSION[user]'");
	if($ata = $qu = $r = mysql_fetch_array($q)){
	
		$user = $r[0] ;
	}
	
	$tim_opd = mysql_query("select * from user_roles where role_id = 2");
		 		 
	while($row = mysql_fetch_array($tim_opd)){
			$tim[] = $row[0];  
	}
		 		 
	if(in_array($_SESSION['id_pegawai'],$tim)){			
		$is_tim = TRUE;	
	}
	
	$admin_bkpp = mysql_query("select * from user_roles where role_id = 0");
		 		 
	while($row = mysql_fetch_array($admin_bkpp)){
			$tim_admin[] = $row[0];  
	}
		 		 
	if(in_array($_SESSION['id_pegawai'],$tim_admin)){
			
		$is_administrator = TRUE;	//ini
	}

	$qu=mysql_query("select current_lokasi_kerja.id_unit_kerja, unit_kerja.nama_baru 
					from current_lokasi_kerja 
					inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja
					where id_pegawai=$ata[id_pegawai]");
	$unit = mysql_fetch_array($qu);
		
		
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
	<link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">		
	<link href="assets/bootstrap/css/tabdrop.css" rel="stylesheet">		
	<link href="assets/bootstrap/css/costums.css" rel="stylesheet">
	
		
	<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
	<link rel="stylesheet" type="text/css" href="administrator/administrator.css">
	<link rel="stylesheet" href="assets/DataTables/media/css/jquery.dataTables.css">
	
	<!--[if lte IE 9]>
		  <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
		  <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js"></script>
	<![endif]--> 

	<script src="js/jquery.min.js"></script>
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

	<!---Load Library metro UI-->
	

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
	<div class="row-fluid">
		<div class="col-md-1 hidden-xs hidden-sm">
			<img src='images/logobgr.png' />
		</div>
		<div class="col-md-11">
			<h2 class="simpeg-brand hidden-xs">					
				SISTEM INFORMASI MANAJEMEN KEPEGAWAIAN
				<br>
				<small>PEMERINTAH KOTA BOGOR</small>
			</h2>
			<h2 class="simpeg-brand visible-xs">					
				SIMPEG
				<br>
				<small>KOTA BOGOR</small>
			</h2>
		</div>		
	</div>
<div class="row-fluid">
<div class="col-lg-12">
<nav class="navbar  navbar-default " role="navigation">
  <!--div class="navbar-inner"-->
  <!--div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">      
	  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index3.php" style="color: orangered;"><span  class="glyphicon glyphicon-home"></span></a>
    </div>
	
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <!--li><a href="#">Link</a></li>
        <li><a href="#">Link</a></li-->
       <!-- tim OPD Menu -->
	   <?php				
			if($is_tim){
		?>
	   <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Pengelola<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a  href="index3.php?x=list2.php">
				<span class="glyphicon glyphicon-list"></span>  
				Daftar Pegawai
				</a>
			</li>
			<li><a  href="index3.php?x=list_by_subid.php">
				<span class="glyphicon glyphicon-th"></span>  
				Hirarki Kepegawaian 
				</a>
			</li>
			<li><a  href="index3.php?x=list_pensiun.php">
				<span></span>  
				Daftar Pensiun
				</a>
			</li>
			<li class="divider"></li>
			<li><a href="index3.php?x=list_tim_skpd.php"><span class="glyphicon glyphicon-list"></span>  Daftar Pengelola Kepegawaian</a></li>           
          </ul>
        </li>		
		<?php } ?>
		<!-- end tim OPD menu -->	
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Laporan <b class="caret"></b></a>
			 <ul class="dropdown-menu">
            <li><a  href="index3.php?x=rekap_peg_opd.php">
				<span class=""></span>  
				Rekap Pegawai
				</a>
			</li>
			<li><a  href="#">
				<span class=""></span>  
				Rekap Pegawai Per OPD
				</a>
			</li>
			<li><a  href="#">
				<span class=""></span>  
				Rekap Pejabat Fungsional
				</a>
			</li>
			<li class="divider"></li>
			<li><a  href="index3.php?x=statistik.php">
				<span class=""></span>  
				Statistik PNS
				</a>
			</li>
			<li class="divider"></li>   
			<li><a  href="index3.php?x=duk.php">
				<span class=""></span>  
				DUK
				</a>
			</li>
			<li><a  href="#" class="dropdown-toggle">
				<span class=""></span>  
				Daftar Nominatif
				</a>
				<ul class="dropdown-menu">
					<li><a href="#" >Nominatif pejabat struktural</a></li>
				</ul>
			</li>
          </ul>
		</li>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Organigram<b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="organigram.php" target="_blank">Organigram</a></li>
				<li><a href="index3.php?x=modul/organigram.php">Organigram <span class="badge">beta</span></a></li>
			</ul>
		</li>
		<li class="dropdown">
			<a href="#"class="dropdown-toggle" data-toggle="dropdown">Informasi<b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="index3.php?x=dini.php">Pensiun</a></li>                    
				<li><a href="index3.php?x=impassing.php">Peninjauan Masa Kerja</a></li>
				<li><a href="index3.php?x=kartu.php">Karpeg, Karisu dan Taspen</a></li>
				<li><a href="index3.php?x=belajar.php">Tugas/Ijin Belajar dan Pencantuman Gelar</a></li>					
			</ul>
		</li>
		<li class="dropdown">
			<a href="#"class="dropdown-toggle" data-toggle="dropdown">Download <span class="badge">1</span><b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a href="index3.php?x=peraturan.php">Peraturan Kepegawaian</a></li>                    
				<li><a href="index3.php?p=download">Lain-lain <span class="badge">1</span></a></li>				
			</ul>
		</li>
      </ul>
      <form class="navbar-form navbar-right " role="search" action="index3.php?x=search.php" method="post" name="searchform" id="searchform">
        <div class="form-group">         
		 <input name="s" type="text" id="s"  size="15" class="form-control" placeholder="Cari Pegawai">
		</div>
        <!--button name="submit" type="submit" class="btn btn-default">
			<span class="glyphicon glyphicon-search"></span> Cari
		</button-->
      </form>
      <ul class="nav navbar-nav navbar-right">       
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			
			<?php echo $ata['nama'] ?>
			<span class="glyphicon glyphicon-cog"><span/>
		  </a>
		  
          <ul class="dropdown-menu">
            <li><a href="index3.php?x=box.php&od=<?php echo $_SESSION[id_pegawai] ?>"><span class="glyphicon glyphicon-pencil"></span>  Edit Data </a></li>
            <li><a href="index3.php?x=ganti_password.php"><span class="glyphicon glyphicon-lock"></span>  Ubah Password</a></li>            
            <li class="divider"></li>
            <li><a href="logout.php?id=<?php echo $_SESSION['id_pegawai'] ?>"><span class="glyphicon glyphicon-log-out"></span>  Log out</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  <!--/div><!-- /.container-fluid -->
  <!--/div-->
</nav>
</div>
</div>
