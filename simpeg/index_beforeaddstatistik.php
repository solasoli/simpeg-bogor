<?php
session_start();
if(isset($_SESSION['user']))
	header('location:index3.php');	

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Sistem Informasi Kepegawaian Pemerintah Kota Bogor">
		<meta name="language" content="indonesia">
		<meta name="author" content="IT@BKPP Team">
		
		<title>::SIMPEG Kota Bogor</title>
		
		<link rel="shortcut icon" href="lib/img/pemkot_icon.jpg"/>
		<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">		
		<link href="assets/bootstrap/css/costums.css" rel="stylesheet">
		 
		<!--[if lte IE 9]>
		  <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
		  <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js"></script>
		<![endif]--> 
		

</head>

<body>	
	<div id="wrapper">
	<br>
	<div class="container-fluid">
		
		<div class="row-fluid">
			<div class="col-md-1">
				<img src='images/logobgr.png' />
			</div>
			<div class="col-md-11">
				<h2 class="">					
					<strong>SISTEM INFORMASI MANAJEMEN KEPEGAWAIAN</strong>
					<br>
					<small>PEMERINTAH KOTA BOGOR</small>
				</h2>
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-12">				
				<!-- navbar -->
				<nav class="navbar navbar-default" role="navigation">
					<div class="navbar-inner">
					  <div class="container-fluid">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
						  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-login">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						  </button>
						  <!--a class="navbar-brand" href="#"></a-->
						</div>

						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse" id="navbar-login">
						  <ul class="nav navbar-nav">
							<li><a href="index.php">HOME</a></li>																
							<li class="dropdown">
							  <a href="#" class="dropdown-toggle" data-toggle="dropdown">PROFIL<span class="caret"></span></a>
							  <ul class="dropdown-menu" role="menu">
								<li><a href="#">Visi & Misi</a></li>										
								<li><a href="#">Tugas & Fungsi</a></li>										
							  </ul>
							</li>
							<li><a href="#contact" data-toggle="modal">HUBUNGI KAMI</a></li>							
						  </ul>
						  <form class="navbar-form navbar-right" role="search">
							<div class="form-group">
							  <input type="text" class="form-control" placeholder="Search">
							</div>
							<button type="submit" class="btn btn-default">Submit</button>
						  </form>						  
						</div><!-- /.navbar-collapse -->
					  </div><!-- /.container-fluid -->
					</div>
				</nav>				
				<!-- end of navbar -->					
			</div>
		</div>
		<div class="row">
			<div class="col-md-9">
				<?php 
					if(isset($_REQUEST['page'])){
					
						switch($_REQUEST['page']){
						
							case 1 :
								include 'modul/page/news.php';
								break;
							case 2 :
								include 'modul/page/pemberkasan_cpns2014.php';
								break;
							default :
								include 'modul/welcome/welcome.php'; 
						}
					}else{
						include 'modul/welcome/welcome.php' ;
					}										
				?>
			</div>
			<div class="col-md-3">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading"><strong>LOG IN</strong></div>
							<div class="panel-body">
								<form class="form-signin" id="form1" name="form1" method="post" action="cek.php" role="form">
								<div class="form-group">												
									<input type="text" class="form-control" placeholder="NIP" name="u" id="u" autofocus="">						
									<input type="password" class="form-control" placeholder="Kata Sandi" name="p" id="p" required="">							
									<input type="submit" class="btn btn-lg btn-danger btn-block" type="submit" value="masuk">						
									</input>							
								</div>
							</form>							
							</div>
						</div>						
					</div>					
				</div><!-- end row-fluid lig in -->
				<div class="row">
					<div class="col-md-12 col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Agenda</strong></div>
							<div class="panel-body"><i>Tidak ada Agenda</i></div>
						</div>
					</div>
				</div><!-- end row-fluid agenda -->
				<div class="row clearfix">
					<div class="col-md-12 col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Links</strong></div>
							<div class="panel-body">
								<ul>
									<li><a href="http://kotabogor.go.id" target="_blank">Pemerintah Kota Bogor</a></li>
									<li><a href="http://bkpp.kotabogor.go.id" target="_blank">BKPP Kota Bogor</a></li>
									<li><a href="http://bkn.go.id" target="_blank">BKN</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div><!-- end row links -->
			</div><!-- end column -->
		</div> <!-- end of row-fluid -->
	</div> <!-- end of container -->
	<div class="container footer" >
		<label >&copy <?php echo date('Y') ?> BKPP - Pemerintah Kota Bogor</label>
	</div>
</div>

<!-- ====================================== -->

 <div class="modal fade" id="contact" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Hubungi Kami</h3>
			</div>
			<div class="modal-body">
				<p>Email : bkpp@kotabogor.go.id / simpeg.kotabogor@gmail.com</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary" data-dismiss="modal">Tutup</a>
			</div>
		</div>
	</div>
</div>
	
<script src="js/jquery.min.js"></script>
<script src="js/jquery.validate.js"></script>
<script src="assets/bootstrap/js/bootstrap.js"></script>
<script language="javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>	
<script src="assets/plugins/totop/easing.js" type="text/javascript"></script>
<script type="text/javascript" src="assets/plugins/totop/jquery.ui.totop.min.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-44687758-1', 'simpeg.kotabogor.go.id');
  ga('send', 'pageview');

</script>
<script type="text/javascript">
	$(window).bind('scroll', function() {
		 if ($(window).scrollTop() > 50) {
			 $('.navbar').addClass('navbar-fixed-top');
		 }
		 else {
			 $('.navbar').removeClass('navbar-fixed-top');
		 }
	});
	$().UItoTop({ easingType: 'easeOutQuart' });
	$(document).ready(function(){
		$("#form1").validate({
			rules: {
				u: {
					required: true,
					/*digits : true,*/
					minlength : 4, 
					maxlength : 18
				},
				p: {
					required: true,
					minlength: 3
				}  
			},
			messages: {
				u: {
					required: "NIP Harap di isi",
					/*digits: "Format NIP salah",*/
					minlength: "NIP salah",
					maxlength: "NIP Salah"
					
				},
				p: {
					required: "Harap di isi",
					minlength: "Password kurang"
				}
			}   
		});	
	});	
		
</script>
</body>

</html>