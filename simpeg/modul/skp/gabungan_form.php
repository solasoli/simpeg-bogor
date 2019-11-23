<?php

	$lastSkp = $skp->get_akhir_periode($pegawai->id_pegawai, $_GET['y']);
	$penilai = $lastSkp->id_penilai_realisasi > 0 ? $obj_pegawai->get_obj($lastSkp->id_penilai_realisasi) : $obj_pegawai->get_obj($lastSkp->id_penilai);
//	$penilai = $lastSkp->id_penilai_realisasi ;


?>
<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Form Penilaian SKP Gabungan <?php echo $obj_pegawai->get_obj($_SESSION['id_pegawai'])->nama_lengkap ?></h5>
		</div>
	</div>
	<div class="visible-print">
	</br></br>
		<h5 class="text-center">FORMULIR PENILAIAN SKP GABUNGAN <br> PEGAWAI NEGERI SIPIL</h5>
	</div>

	<div>
		<label>Nama</label>: <?php echo $pegawai->nama_lengkap ?> </br>
		<label>NIP</label>: <?php echo $pegawai->nip_baru ?>
	</div>
	<div class="panel-body">
		<table class="clearfix table table-bordered">
			<thead>
				<tr class="text-center">
					<th width="2%">No</th>
					<th width="25%" class="text-center">Masa Penilaian</th>
					<th >Uraian</th>
					<th width="33%" class="text-center">Nama/Nip dan Paraf Pejabat Penilai</th>
				</tr>
			</thead>
			<tbody>

					<tr>
						<td rowspan="2">
						<?php
							$list_skp = $skp->get_skp_by_tahun($pegawai->id_pegawai,$_GET['y']);
							if(mysqli_num_rows($list_skp) > 0){
							$x=1;
							while($each_skp = mysqli_fetch_object($list_skp)){
								echo $x++.".</br>";
							}}
						?>
						</td>
						<td width="30%" rowspan="2">
						<?php
							$list_skp = $skp->get_skp_by_tahun($pegawai->id_pegawai,$_GET['y']);
							if(mysqli_num_rows($list_skp) > 0){

							while($each_skp = mysqli_fetch_object($list_skp)){
								echo $format->tanggal_indo($each_skp->periode_awal,"d-m")." - ".$format->tanggal_indo($each_skp->periode_akhir);
								echo "</br>";
							}}
						?>
						</td>
						<td>
							<?php
							$list_skp = $skp->get_skp_by_tahun($pegawai->id_pegawai,$_GET['y']);
							if(mysqli_num_rows($list_skp) > 0){
							$x=1;
							while($each_skp = mysqli_fetch_object($list_skp)){
								echo "Nilai capaian SKP = ".$nilai[] = $skp->get_nilai_capaian($each_skp->id_skp)->rata2_nilai_skp;
								echo "</br>";
							}}
						?>

						</td>
						<td align="center" rowspan="2" >
							<span><?php  echo $lastSkp->jabatan_penilai_realisasi ?></span>
							<br><br><br><br>
							<span style="text-decoration:underline"><strong><?php echo $penilai->nama_lengkap; ?></strong></span>
							<br>
							<span>NIP. <?php echo $penilai->nip_baru ?></span>
						</td>
					</tr>
					<tr>
						<td>
							<?php
								echo "<span>Jumlah</span> = ".array_sum($nilai);
								echo "</br>";
								echo "<span>Nilai Rata-rata</span> = ".number_format(array_sum($nilai) / count($nilai),2);
							?>
							</br></br></br>
						</td>

			</tbody>
		</table>
	</div>
	<div class="panel-footer hidden-print">
		<a href="#" class="btn btn-info" type="button" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></a>
	</div>
</div>



<script>

	$(document).ready(function(){

		$(".in").removeClass("in");
		$("#collapseOne").addClass("in");

	});


</script>
<script src="skp.js"></script>
