<?php
session_start(); 
require_once("../../konek.php");
//require_once "../../class/duk.php";
require_once "../../class/unit_kerja.php";
require_once("../../library/format.php");

if(! isset($_SESSION['user'])) header('location: '.BASE_URL.'index.php');

$format = new Format;
$uk = new Unit_kerja;


?>

<!DOCTYPE html>
<html class="no-js">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<meta name="keywords" content="" />
	<meta name="description" content="Sistem Informasi Kepegawaian Pemerintah Kota Bogor">
	
	<title>Daftar Nominatif::SIMPEG</title>
	
	<link rel="shortcut icon" href="../../lib/img/pemkot_icon.jpg"/>		
	<link href="<?php echo BASE_URL ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">		
	<!--link href="<?php echo BASE_URL ?>assets/bootstrap/css/tabdrop.css" rel="stylesheet"-->		
	<link href="<?php echo BASE_URL ?>assets/bootstrap/css/costums.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo BASE_URL ?>assets/DataTables/media/css/jquery.dataTables.css">
	<link href="<?php echo BASE_URL ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo BASE_URL ?>assets/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo BASE_URL ?>assets/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" />
		
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
			<div class="col-md-12" id="judul">
				<h1>DAFTAR NOMINATIF PEGAWAI</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 well" id="pilter">
								
					<div class="form-group">
					<label for="skpd">SKPD</label>
					<select id="skpd" class="form-control">
						<option value="0">Semua SKPD</option>
						<?php
							$skpds = $uk->get_skpd_list();
														
							foreach($skpds as $skpd){
						?>
								<option value="<?php echo $skpd->id_unit_kerja?>"><?php echo $skpd->nama_baru ?></option>
						<?php								
								
							}
							
						?>
					
					</select>
					</div>
					<div class="form-group">
					<label for="unit_kerja">Unit Kerja</label>
					<select class="form-control" id="unit_kerja">
						<option value="0">Semua</option>
						<div id="list_unit_kerja"></div>
					</select>
					</div>
					<button id="btnDisplay" class="btn btn-primary">Tampilkan</button>					
				
			</div>
			<div class="col-md-6" id="regenerate">
				<button id="btnGenerate" class="btn btn-success">Hitung Ulang DUK</button>
			</div>
		</div>
		<div class="row">		
		<div class="col-md-12 table-responsive" id="content">
			
		</div>
		</div><!-- end of row -->
	</div><!-- end of div content -->
	
</div><!-- end of wrapper -->

	<script src="<?php echo BASE_URL ?>assets/jquery-ui/jquery-ui.min.js"></script>

</body>	
</html>
<script type="text/javascript">
$(document).ready(function(){

	$("#btnDisplay").click(function(){
		$("#content").html("LOADING");
		
		id_skpd = $("#skpd").val();
		
		if(id_skpd == 0){
			
			$.post("nominatif_show.php", {id_skpd : null }, function(data){
				$("#content").html(data);
			});
		}else{
			
			id_unit_kerja = $("#unit_kerja").val();
			
			if(id_unit_kerja == 0){
				$.post("nominatif_show.php", {id_skpd : $("#skpd").val() }, function(data){
					$("#content").html(data);
				});
			}else{
				$.post("nominatif_show.php", {id_skpd : id_skpd, 
										id_unit_kerja : id_unit_kerja }, function(data){
					$("#content").html(data);
				});
			}
			
		}		
		
	});
	
	$("#skpd").change(function(){
		
		id_skpd = $("#skpd").val();
		
		$.post("unit_kerja_list.php",{id_skpd : id_skpd}, function(data){
				//alert(data);
				$("#unit_kerja").find('option').remove();
				$("#unit_kerja").append("<option value='0'>Semua Unit Kerja</option>");
				$("#unit_kerja").append(data);
			});
		
	});
	
	
	$("#btnGenerate").click(function(){
			
			q = confirm("Menghitung Ulang DUK memerlukan waktu yang cukup lama \nPastikan semua data sudah di perbaiki sebelum dilakukan penghitungan ulang \nanda yakin menghitung ulang ?");
			
			
			if(q == true){
				id_skpd = $("#skpd").val();
				id_unit_kerja = $("#unit_kerja").val();
				
				$("#content").html("Menghitung Ulang DUK ...");
				
				if(id_skpd == 0){
					
					q2 = "Anda akan menghitung ulang DUK Kota Bogor";
					q2 += "\nIni akan memakan waktu yang lama dan membebani Server";
					q2 += "\nJika data yang diperbarui sedikit, pilih terlebih dahulu skpd atau unit kerja untuk lebih meringankan beban server";
					q2 += "\nHitung Ulang DUK ?";
					
					q2 = confirm(q2);
					
					if(q2 == true){
						$.post("generate.php",{id_skpd : null},function(data){
							$("#content").html(data);
						});
					}else{
						$("#content").html("Membatalkan Penghitungan Ulang DUK");
					}					
					
				}else{
					
					if(id_unit_kerja == 0){
						$.post("generate.php",{id_skpd : id_skpd},function(data){
							$("#content").html(data);							
						});
					}else{
						$.post("generate.php",{id_skpd : id_skpd, id_unit_kerja : id_unit_kerja	},function(data){
							$("#content").html(data);
						});
					}
					
				}
			}else{
				$("#content").html("Membatalkan Penghitungan Ulang DUK");
			}
		});
	
});
</script>
