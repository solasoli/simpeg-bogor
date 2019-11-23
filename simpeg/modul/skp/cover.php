<?php 


	$pegawai = $obj_pegawai->get_obj($_GET['idp']);
	//$penilai = $skp->get_penilai($pegawai);
	$lastSkp = $skp->get_akhir_periode($_GET['idp'], $_GET['tahun']);
	
	//$atasan_penilai = $skp->get_penilai($penilai);
	//$perilaku = $skp->get_skp_by_id($_GET['idskp']);
	
	
?>
<br/>
<div class="row text-center">
	<div class="col-md-12">
		<span>
			<img src="<?php echo BASE_URL?>images/garuda.jpg" style="width:120px; height:120px">
		</span>
		<h2>
		PENILAIAN PRESTASI KERJA<br>PEGAWAI NEGERI SIPIL
		</h2>
	</div>
</div>

<br/><br/><br/>

<div class="row text-center">
	<div class="col-sm-12">
		<h3>
		<strong>JANGKA WAKTU PENILAIAN</strong><br/>
		<?php echo $format->tanggal_indo($skp->get_awal_periode($_GET['idp'], $_GET['tahun'])->awal, "m")
					." s.d ".$format->tanggal_indo($lastSkp->akhir, "m-Y") ;
		?>
		</h3>
	</div>	
</div>
<br/><br/><br/>
<div class="row text-center">
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
		<table class="table table-noborder text-left">
			<tr>
				<td width="35%">Nama Pegawai</td>
				<td>:</td>
				<td><?php echo $pegawai->nama_lengkap ?></td>
			</tr>
			<tr>
				<td>NIP</td>				
				<td>:</td>
				<td><?php echo $pegawai->nip_baru?></td>
			</tr>
			<tr>
				<td>Pangkat, Gol/Ruang</td>
				<td>:</td>
				<td><?php echo isset($lastSkp->gol_pegawai)? $lastSkp->gol_pegawai : $pegawai->pangkat." - ".$pegawai->golongan ?></td>
			</tr>
			<tr>
				<td>Jabatan</td>
				<td>:</td>
				<td><?php echo $lastSkp->jabatan_pegawai?></td>
			</tr>
			<tr>
				<td>Unit Kerja</td>
				<td>:</td>
				<td><?php echo $unit_kerja->get_unit_kerja($lastSkp->id_unit_kerja_pegawai)->nama_baru ?></td>
			</tr>
		</table>
	</div>
</div>
<br/><br/>
<div class="row text-center">
	<div class="col-sm-12">
		<h3><small>
			PEMERINTAH KOTA BOGOR <br/>
			<?php echo strtoupper($unit_kerja->get_skpd_by_id_unit_kerja($lastSkp->id_unit_kerja_pegawai)->skpd) ?>
			<br/>TAHUN <?php echo $format->tanggal_indo($lastSkp->akhir, "Y") ?>
			</small>
		</h3>
	</div>
</div>
<div class="page-break"></div>	

<script>
	$(document).ready(function(){
		window.print();
		$(".in").removeClass("in");
		$("#collapseOne").addClass("in");
	});
</script>
