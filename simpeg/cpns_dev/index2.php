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
	
</head>
<body>
	
<div class="container">
	<div class="row">
		<div class="col-md-12 well">
			<h1>Jadwal dan Lokasi Ujian CAT CPNS Kota Bogor Tahun 2014</h1>
		</div>
	</div>
			
	
	
	<div class="row" id="1">
		<div class="col-md-12">
			<?php include "pengumuman.php" ?>
			<button  class="btn btn-primary" id="btn1">Lanjut</button>
		</div>
	</div><!-- end of row pengumuman -->
	
	<div class="row hide" id="2">
		<div class="col-md-12">
			<?php include "tatib.php"; ?>
			<button  class="btn btn-primary" id="btn2a">Kembali</button>
			<button  class="btn btn-primary" id="btn2b">Lanjut</button>
		</div>
	</div> <!-- end of row tatib -->
		
	<div class="row hide" id="3">		
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					Masukan nomor peserta anda:<br/>
					<input id="no_peserta" type="text" name="no_peserta" />
					<input id="btn_search" type="submit" value="Tampilkan" />
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<fieldset id="fieldset">
						<div id="content"></div>
					</fieldset>
					<button  class="btn btn-primary" id="btn3">Kembali</button>
				</div>
			</div>			
		</div><!-- end of column cari jadwal -->
		<div class="col-md-6">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.3102425623847!2d106.81022999999998!3d-6.608318!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c5e76bc62fff%3A0x244fbdf5858a8aba!2sSMK+Negeri+3+Bogor!5e0!3m2!1sen!2sid!4v1412594778966" width="600" height="450" frameborder="0" style="border:0"></iframe>
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
		});
		
		$("#btn3").click(function(){
			$("#3").hide();
			$("#2").show();
		});
	});
	</script>

</body>
</html>
