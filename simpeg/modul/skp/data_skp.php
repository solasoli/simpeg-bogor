<?php
	$pegawai = $obj_pegawai->get_obj($_GET['idp']);
	//$penilai = $skp->get_penilai($pegawai);
	$lastSkp = $skp->get_akhir_periode($_GET['idp'], $_GET['tahun']);
	$penilai = $obj_pegawai->get_obj($lastSkp->id_penilai);
	$atasan_penilai = $obj_pegawai->get_obj($lastSkp->id_atasan_penilai);
	//$atasan_penilai = $skp->get_penilai($penilai);
	//$perilaku = $skp->get_skp_by_id($_GET['idskp']);


?>
<div class="row hidden-print">
	<div class="col-md-12">
		<button class="btn btn-info" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></button>
	</div>
</div>



<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered">
			<tr>
				<td rowspan="6" width="2%">1.</td>
				<td colspan="2">YANG DINILAI</td>
			</tr>
			<tr>
				<td width="38%">a. Nama</td>
				<td><?php echo $pegawai->nama_lengkap ?></td>
			</tr>
			<tr>
				<td>b. NIP</td>
				<td><?php echo $pegawai->nip_baru ?></td>
			</tr>
			<tr>
				<td>c. Pangkat, Golongan/ruang</td>
				<td><?php echo isset($lastSkp->gol_pegawai)? $lastSkp->gol_pegawai : $pegawai->pangkat." - ".$pegawai->pangkat_gol ?></td>
			</tr>
			<tr>
				<td>d. Jabatan/Pekerjaan</td>
				<td><?php echo $lastSkp->jabatan_pegawai ?></td>
			</tr>
			<tr>
				<td>e. Unit Organisasi</td>
				<td><?php echo $unit_kerja->get_unit_kerja($lastSkp->id_unit_kerja_pegawai)->nama_baru ?></td>
			</tr>
			<tr>
				<td rowspan="6">2.</td>
				<td colspan="2">PEJABAT PENILAI</td>
			</tr>
			<tr>
				<td>a. Nama</td>
				<td><?php echo $penilai->nama_lengkap ?></td>
			</tr>
			<tr>
				<td>b. NIP</td>
				<td><?php echo $penilai->nip_baru ?></td>
			</tr>
			<tr>
				<td>c. Pangkat, Golongan/ruang</td>
				<td><?php echo isset($lastSkp->gol_penilai)? $lastSkp->gol_penilai : $penilai->pangkat." - ".$penilai->pangkat_gol ?></td>
			</tr>
			<tr>
				<td>d. Jabatan/Pekerjaan</td>
				<td><?php echo $lastSkp->jabatan_penilai ?></td>
			</tr>
			<tr>
				<td>e. Unit Organisasi</td>
				<td><?php echo $unit_kerja->get_unit_kerja($lastSkp->id_unit_kerja_penilai)->nama_baru ?></td>
			</tr>
			<tr>
				<td rowspan="6">3.</td>
				<td colspan="2">ATASAN PEJABAT PENILAI</td>
			</tr>
			<tr>
				<td>a. Nama</td>
				<td><?php echo $atasan_penilai->nama_lengkap ?></td>
			</tr>
			<tr>
				<td>b. NIP</td>
				<td><?php echo is_numeric($atasan_penilai->nip_baru) ? $atasan_penilai->nip_baru : "-" ?></td>
			</tr>
			<tr>
				<td>c. Pangkat, Golongan/ruang</td>
				<td>
					<?php echo isset($lastSkp->gol_atasan_penilai)? $lastSkp->gol_atasan_penilai : $atasan_penilai->pangkat." - ".$atasan_penilai->pangkat_gol ?>

				</td>
			</tr>
			<tr>
				<td>d. Jabatan/Pekerjaan</td>
				<td><?php echo $lastSkp->jabatan_atasan_penilai ?></td>
			</tr>
			<tr>
				<td>e. Unit Organisasi</td>
				<td><?php echo $unit_kerja->get_unit_kerja($lastSkp->id_unit_kerja_atasan_penilai)->nama_baru  ?></td>
			</tr>
		</table>
	</div>
</div>
<div class="page-break"></div>

<script>
	$(document).ready(function(){

		$(".in").removeClass("in");
		$("#collapseOne").addClass("in");
	});
</script>
