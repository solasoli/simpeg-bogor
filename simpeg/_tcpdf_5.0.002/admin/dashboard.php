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
			<h5>DAFTAR PEGAWAI</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center"> PILIH DAFTAR PEGAWAI</h5>
	</div>
	<div class="panel-body">
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
	</div>
	<div class="panel-footer">
		<button id="btnDisplay" class="btn btn-primary"><span class="glyphicon glyphicon-play"></span> TAMPILKAN</button>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>DAFTAR PEGAWAI</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center"> PILIH DAFTAR PEGAWAI</h5>
	</div>
	<div class="panel-body">
		<?php include "daftar_pegawai.php" ?>
	</div>	
</div>