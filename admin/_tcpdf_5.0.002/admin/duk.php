<?php
session_start(); 
require_once("../konek.php");
require_once "../class/unit_kerja.php";
require_once("../library/format.php");

if(! isset($_SESSION['user'])) header('location: '.BASE_URL.'index.php');

$format = new Format;
$uk = new Unit_kerja;

?>
<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>DAFTAR URUT KEPANGKATAN</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">MENU UNDUH<br> DAFTAR URUT KEPANGKATAN</h5>
	</div>
	
	<div class="panel-body">
		<div class="form-group">
			<label for="skpd">SKPD</label>
			<select id="skpd" class="form-control">
				<option value="0">Semua SKPD</option>
				<?php
					$skpds = $uk->get_skpd_list_tahun(2015);
												
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
	</div>
	
	<div class="panel-footer">
		<button id="btnDUK" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span> UNDUH DUK</button>
	</div>
</div>
<div id="content"></div>

<script type="text/javascript">
	$(document).ready(function(){
		
		$("#skpd").on("change",function(){
		
			id_skpd = $("#skpd").val();
			
			$.post("unit_kerja_list.php",{id_skpd : id_skpd}, function(data){
					//alert(data);
					$("#unit_kerja").find('option').remove();
					$("#unit_kerja").append("<option value='0'>Semua Unit Kerja</option>");
					$("#unit_kerja").append(data);
				});
		
		}); 
		
		$("#btnDUK").on("click",function(){
			opd = $("#skpd").val();
			
			//window.location.assign("<?php echo BASE_URL.'admin/duk_table.php?opd='?>"+opd);
			
		if(opd == 0){
			/*
			$.post("duk_table.php", {opd : null }, function(data){
				$("#content").html(data);
			});
			*/
			window.open("<?php echo BASE_URL.'admin/duk_table.php'?>","_blank");
		}else{
			
			id_unit_kerja = $("#unit_kerja").val();
			
			if(id_unit_kerja == 0){
				window.open("<?php echo BASE_URL.'admin/duk_table.php?opd='?>"+opd,"_blank");
			}else{
				window.open("<?php echo BASE_URL.'admin/duk_table.php?opd='?>"+opd+"&uk="+id_unit_kerja,"_blank");
			}
			
		}		
		});
	});
</script>