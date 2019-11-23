<?php
session_start(); 
extract($_GET);
require_once("../../konek.php");
require_once "../../class/pegawai.php"; //nanti pindahkan ke global header ye..
require_once("../../class/unit_kerja.php");
require_once("../../library/format.php");
require "skp.php";

if(! isset($_SESSION['user'])) header('location: '.BASE_URL.'index.php');

$format = new Format;
$obj_pegawai = new Pegawai;
$skp = new Skp;
$pegawai = $obj_pegawai->get_obj($_SESSION['id_pegawai']);	
$unit_kerja = new Unit_kerja;

$ppk = $skp->get_skp_by_id($_GET['idskp']);		

$penilai = $obj_pegawai->get_obj($ppk->id_penilai);
$atasan_penilai = $skp->get_penilai($penilai);

if(isset($ppk->id_penilai_realisasi)){
	$ppk_realisasi = $skp->get_skp_by_id($_GET['idskp']);
	$penilai_realisasi = $obj_pegawai->get_obj($ppk->id_penilai_realisasi);
	$atasan_penilai_realisasi = $obj_pegawai->get_obj($ppk->id_atasan_penilai_realisasi);
	
}else{
	$ppk_realisasi = $ppk;
	$penilai_realisasi = $obj_pegawai->get_obj($ppk->id_penilai);
	$atasan_penilai_realisasi = $obj_pegawai->get_obj($ppk->id_atasan_penilai);
	
}



?>


<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>DATA SKP PERIODE PENILAIAN: </h5>			
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center"><strong>DATA SKP</strong></h5>		 
	</div>
	
	<div class="panel-body">
		<table class="clearfix table table-bordered" id="skp_target_table">
			<!-- pns-->
			<tr>
				<td width="2%"><strong>I.</strong></td>
				<td colspan="5"><strong>PNS YANG DINILAI</strong></td>					
			</tr>
			<tr>				
				<td></td>
				<td width="10%">Nama</td>
				<td colspan="4"><?php echo $pegawai->nama_lengkap ?></td>
			</tr>
			<tr>				
				<td></td>
				<td>NIP</td>
				<td colspan="4"><?php echo $pegawai->nip_baru ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Pangkat/Gol.Ruang</td>
				<td colspan="4"><?php echo isset($ppk->gol_pegawai) ? $ppk->gol_pegawai : $pegawai->pangkat." - ".$pegawai->pangkat_gol  ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Jabatan</td>
				<td colspan="4"><?php echo $skp->get_skp_by_id($_GET['idskp'])->jabatan_pegawai ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Unit Kerja</td>
				<td colspan="4"><?php echo $unit_kerja->get_unit_kerja($ppk->id_unit_kerja_penilai)->nama_baru ?></td>
			</tr>	
			<!-- end of pns -->
			
			<!-- pejabat penilai-->	
			<tr>
				<td width="2%"><strong>II.</strong></td>
				<td colspan="2" width="48%"><strong>PEJABAT PENILAI TARGET</strong></td>
				<td colspan="5">
					<strong>PEJABAT PENILAI REALISASI</strong>
					<span class="pull-right">
						<button id="btnUbahPejabatPenilai" class="btn btn-primary">ubah</button>
					</span>
				</td>				
			</tr>
			<tr>
				<td></td>
				<td width="10%">Nama</td>
				<td><?php echo $penilai->nama_lengkap ?></td>								
				<td colspan="2"><?php echo $penilai_realisasi->nama_lengkap ?></td>
			</tr>
			<tr>
				<td></td>
				<td>NIP</td>
				<td><?php echo $penilai->nip_baru ?></td>				
				<td colspan="4"><?php echo $penilai_realisasi->nip_baru ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Pangkat/Gol.Ruang</td>
				<td><?php echo isset($ppk->gol_penilai) ? $ppk->gol_penilai : $penilai->pangkat." - ".$penilai->pangkat_gol  ?></td>
				<td colspan="4"><?php echo isset($ppk->gol_penilai) ? $ppk->gol_penilai : $penilai_realisasi->pangkat." - ".$penilai_realisasi->pangkat_gol  ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Jabatan</td>
				<td><?php echo $ppk->jabatan_penilai;?></td>
				<td colspan="4"><?php echo $skp->get_skp_by_id($_GET['idskp'])->jabatan_penilai ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Unit Kerja</td>
				<td><?php echo $unit_kerja->get_unit_kerja($ppk->id_unit_kerja_pegawai)->nama_baru ?></td>
				<td colspan="4"><?php echo $unit_kerja->get_unit_kerja($ppk->id_unit_kerja_penilai)->nama_baru ?></td>
			</tr>
			
			
			<!-- atasan pejabat penilai-->	
			<tr>
				<td width="2%"><strong>III.</strong></td>
				<td colspan="2" width="48%"><strong>ATASAN PEJABAT PENILAI TARGET</strong></td>
				<td colspan="5">
					<strong>ATASAN PEJABAT PENILAI REALISASI</strong>
					<span class="pull-right">
						<button class="btn btn-primary">ubah</button>
					</span>
				</td>				
			</tr>
			<tr>
				<td></td>
				<td width="10%">Nama</td>
				<td><?php echo $penilai->nama_lengkap ?></td>								
				<td colspan="2"><?php echo $pegawai->nama_lengkap ?></td>
			</tr>
			<tr>
				<td></td>
				<td>NIP</td>
				<td><?php echo $penilai->nip_baru ?></td>				
				<td colspan="4"><?php echo $pegawai->nip_baru ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Pangkat/Gol.Ruang</td>
				<td><?php echo isset($ppk->gol_penilai) ? $ppk->gol_penilai : $penilai->pangkat." - ".$penilai->pangkat_gol  ?></td>
				<td colspan="4"><?php echo isset($ppk->gol_pegawai) ? $ppk->gol_pegawai : $pegawai->pangkat." - ".$pegawai->pangkat_gol  ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Jabatan</td>
				<td><?php echo $ppk->jabatan_penilai; //$obj_pegawai->get_jabatan($penilai) ?></td>
				<td colspan="4"><?php echo $skp->get_skp_by_id($_GET['idskp'])->jabatan_pegawai ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Unit Kerja</td>
				<td><?php echo $unit_kerja->get_unit_kerja($ppk->id_unit_kerja_pegawai)->nama_baru ?></td>
				<td colspan="4"><?php echo $unit_kerja->get_unit_kerja($ppk->id_unit_kerja_penilai)->nama_baru ?></td>
			</tr>
			
			<!-- tanggal -->
			<tr>
				<td><strong>IV.</strong></td>
				<td colspan="4">
					<strong>TANGGAL</strong>
					<span class="pull-right">
						<button class="btn btn-primary">ubah</button>
					</span>
				</td>				
			</tr>
			<tr>
				<td></td>
				<td>Tanggal dibuat</td>
				<td></td>				
			</tr>
			<tr>
				<td></td>
				<td>Tanggal diterima PNS</td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td>Tanggal diterima atasan penilai</td>
				<td></td>
			</tr>
		</table>
	</div>
	
	<div class="panel-footer hidden-print">		 
		<a href="#" class="btn btn-primary" id="btnCetak" type="button" onclick="window.print()">
			<span class="glyphicon glyphicon-print"></span>
		</a>
		<span class="pull-right">
			status : <span class="danger"><?php echo $skp->get_status($skp->get_skp_by_id($_GET['idskp'])->status_pengajuan)->status ?></span>
		</span>		
	</div>	
</div>


<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="modal fade" id="ubahPejabatPenilai" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Ubah Pejabat Penilai</h5>
			</div>
			<div class="modal-body ">				
				
				<form class="form-horizontal">
				
				  <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">NIP</label>
					<div class="col-sm-5">
					  <input type="text" class="form-control" id="inputEmail3" placeholder="Penilai Target">
					</div>
					<div class="col-sm-5">
					  <input type="text" class="form-control" id="inputEmail3" placeholder="Penilai Realisasi">
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">Nama</label>
					<div class="col-sm-5">
					  <input type="password" class="form-control" id="inputPassword3" placeholder="Nama">
					</div>
					<div class="col-sm-5">
					  <input type="password" class="form-control" id="inputPassword3" placeholder="Nama">
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">Pangkat</label>
					<div class="col-sm-5">
					  <input type="password" class="form-control" id="inputPassword3" placeholder="Pangkat">
					</div>
					<div class="col-sm-5">
					  <input type="password" class="form-control" id="inputPassword3" placeholder="Pangkat">
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">Jabatan</label>
					<div class="col-sm-5">
					  <input type="password" class="form-control" id="inputPassword3" placeholder="Jabatan">
					</div>
					<div class="col-sm-5">
					  <input type="password" class="form-control" id="inputPassword3" placeholder="Jabatan">
					</div>
				  </div>
				</form>
					
			</div>
			<div class="modal-footer">
				<a  onclick="berikutnya()" data-toggle="modal" class="btn btn-primary">Berikutnya</a>
				<a class="btn btn-danger" data-dismiss="modal">batal</a>
			</div>
		</div>
	</div>
</div>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<script>
	
	
	$(document).ready(function(){
		$("#btnUbahPejabatPenilai").click(function(){
			//$('#formTambahUraian')[0].reset();
			$("#ubahPejabatPenilai").modal("show");	
		});
		
	});

</script>
