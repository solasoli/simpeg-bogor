<html>
<head>
	<title>Jadwal & Lokasi CAT 2014</title>
	<!--link rel="stylesheet" href="css/metro-bootstrap.css">
	<link rel="stylesheet" href="css/metro-bootstrap-responsive.css"-->
	<link href="../assets/bootstrap/css/bootstrap.css" rel="stylesheet">		
	<link href="../assets/bootstrap/css/costums.css" rel="stylesheet">
	
	<script type="text/javascript" src="min/jquery.min.js"></script>		    
    <script src="js/jquery/jquery.widget.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.js"></script>
    <!--script src="js/metro/metro.min.js"></script-->
	<style>
	.google-maps {
	position: relative;
	padding-bottom: 75%; // This is the aspect ratio
	height: 0;
	overflow: hidden;
	}
	.google-maps iframe {
	position: absolute;
	top: 0;
	left: 0;
	width: 100% !important;
	height: 100% !important;
	}
	</style>
</head>
<body>
	
<div class="container">
	<div class="row">
		<div class="col-md-12 well">
			<h1>Tata Tertib, Jadwal dan Lokasi CAT CPNS Kota Bogor Tahun 2014</h1>
		</div>
	</div>
			
	
	<div id="1">
	<div class="row">
		<div class="col-md-12">
			<?php include "pengumuman.php" ?>			
		</div>
	</div><!-- end of row pengumuman -->
	<div class="row hidden-print">
		<button  class="btn btn-primary " id="btn1">Lanjutkan <span class="glyphicon glyphicon-chevron-right"></span></button>
		<br><br>
	</div>
	</div>
	<div class="row hide" id="2">
		<div class="col-md-12">
			<?php include "tatib.php"; ?>
			<button  class="btn btn-primary hidden-print" id="btn2a"><span class="glyphicon glyphicon-chevron-left"></span> Kembali</button>
			<button  class="btn btn-primary hidden-print" id="btn2b">Lanjutkan <span class="glyphicon glyphicon-chevron-right"></span></button>
			<br><br>
		</div>
	</div> <!-- end of row tatib -->
		
	<div class="row" id="3">		
		<div class="col-xs-12 col-md-6">
			<div class="row hidden-print">
				<div class="col-md-12">
					<label for="no_peserta">Masukan nomor peserta anda:</label>
					<input id="no_peserta" type="text" name="no_peserta" class="form-control "/>
					<button id="btn_search" name="btn_search" type="submit" class="btn btn-default "><span class="glyphicon glyphicon-search"></span> Tampilkan</button>					
					<br>
				</div>				
			</div>
			<div class="row">
				<div class="col-md-12">
					<fieldset id="fieldset">
						<div id="content"></div>
					</fieldset>
					<br>
				</div>
			</div>			
		</div><!-- end of column cari jadwal -->
		<div id="peta" class="col-xs-12 col-md-6 google-maps hidden-print" style="height : 300px">
			
		</div>
		<div class="row hidden-print">
			<button  class="btn btn-primary" id="btn3"><span class="glyphicon glyphicon-chevron-left"> Kembali </span></button>
			<br><br>
		</div>
	</div> <!-- end of content row -->
	
	                      
	
</div> <!-- end of wrapper -->
<script>
	$(document).ready(function(){
		$("#no_peserta").focus()
		$("#fieldset").hide();
				

		$("#btn_search").click(function(){
			if($("#no_peserta").val() == '')
				return;
			
			$("#fieldset").fadeIn(400);
			$("#content").html("Mencari, harap tunggu ...");			
			$.post('cari.php', { no_peserta: $("#no_peserta").val() }, function(data){
				$("#content").html(data);	
			});
		});
		
		
		$("#btn1").click(function(){
			$("#1").hide();
			$("#2").removeClass('hide');
			$("#2").show();					
		});
		
		$("#btn2a").click(function(){
			$("#2").hide();
			$("#1").show();
			
		});
		
		$("#btn2b").click(function(){
			$("#2").hide();
			$("#3").removeClass('hide');
			$("#3").show();
			//$("#peta").html("<iframe src='https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3963.3102425623847!2d106.81022999999999!3d-6.608318!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c5e76bc62fff%3A0x244fbdf5858a8aba!2sSMK+Negeri+3+Bogor!5e0!3m2!1sen!2sid!4v1412618551055' width='400' height='300' frameborder='0' style='border:0'></iframe>");
			$("#peta").html("<iframe src='https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31706.38865670303!2d106.8130539!3d-6.6097729!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c42df2b28335%3A0xd3de424537b5fbc7!2sSMK+NEGERI+3+BOGOR!5e0!3m2!1sen!2sid!4v1412644584442' width='600' height='450' frameborder='0' style='border:0'></iframe>");
			
		});
		
		$("#btn3").click(function(){
			$("#3").hide();
			$("#2").show();
		});

		$("#3").hide();
	});
	</script>

</body>
</html>
