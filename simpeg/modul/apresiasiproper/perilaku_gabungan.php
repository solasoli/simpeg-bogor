<?php

	//$perilaku = $skp->get_skp_by_id($_GET['idskp']);
  $lastSkp = $skp->get_akhir_periode($_GET['idp'], $_GET['tahun']);
	if(isset($lastSkp->id_penilai_realisasi)){
		$penilai = $obj_pegawai->get_obj($lastSkp->id_penilai_realisasi);
		//$atasan_penilai = $obj_pegawai->get_obj($perilaku->id_atasan_penilai_realisasi);

	}else{
		$penilai = $obj_pegawai->get_obj($lastSkp->id_penilai);
		//$atasan_penilai = $perilaku->get_penilai($penilai);
	}

	$list_skp = $skp->get_skp_by_tahun($pegawai->id_pegawai,'2015');

	if(mysql_num_rows($list_skp) > 0){

	while($each_skp = mysql_fetch_object($list_skp)){
		$nilai[] = $skp->get_nilai_capaian($each_skp->id_skp)->rata2_nilai_skp;

	}}
?>
<div class="hidden-print">
PERIODE : <?php echo $format->tanggal_indo($skp->get_awal_periode($_GET['idp'], $_GET['tahun'])->awal)
." s.d ".$format->tanggal_indo($lastSkp->akhir) ;//$format->date_dmY($theSkp->periode_awal)." s.d. ".$format->date_dmY($theSkp->periode_akhir)?>

</div>
<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Buku Catatan Penilaian Perilaku <?php echo $obj_pegawai->get_obj($_GET['idp'])->nama_lengkap ?></h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">BUKU CATATAN PENILAIAN PERILAKU <br> PEGAWAI NEGERI SIPIL</h5>
	</div>
	<div class="panel-body">
		<table class="clearfix table table-bordered">
			<thead>
				<tr class="text-center">
					<th>No</th>
					<th width="15%" class="text-center">Tanggal</th>
					<th colspan="3" style="width='30%" class="text-center">Uraian</th>
					<th  class="text-center">Nama/Nip dan Paraf Pejabat Penilai</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td rowspan="9">1</td>
					<td rowspan="9" width="20%"><?php // echo $format->tanggal_indo($perilaku->periode_awal) ?>
						<?php   echo $format->tanggal_indo($skp->get_awal_periode($_GET['idp'], $_GET['tahun'])->awal)
                      ." s.d ".$format->tanggal_indo($lastSkp->akhir)
						?></td>
					<td colspan="3">
						Penilaian SKP sampai dengan <?php echo $format->tanggal_indo($lastSkp->akhir) ?> =
						<?php //echo array_sum($nilai) / count($nilai) ?>
						<?php // echo  $skp->get_nilai_capaian_rata2($_SESSION['id_pegawai'], $date->format("Y"),2)
								 echo $skp->get_nilai_capaian_rata2($_GET['idp'],$_GET['tahun'])  ?>, <br>
						sedangkan penilaian perilaku kerjanya adalah sebagai berikut:
					</td>
					<td rowspan="9" style="vertical-align:middle" class="text-center">
						<span><?php
							if(isset($lastSkp->jabatan_penilai_realisasi)){
								echo $lastSkp->jabatan_penilai_realisasi;
							}else{
								echo $lastSkp->jabatan_penilai;
							}
							?>
						</span>
						<br><br><br><br>

						<span style="text-decoration:underline"><strong><?php echo $penilai->nama_lengkap ?></strong></span>
						<br>
						<span><?php echo $penilai->flag_pensiun > 1 ? "" : "NIP. ".$penilai->nip_baru ?></span>
					</td>
				</tr>
				<tr>

					<td width="10%">
						Orientasi Pelayanan  </td>
					<td class="text-center"><?php echo $lastSkp->orientasi_pelayanan ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($lastSkp->orientasi_pelayanan) ?>)</td>
				</tr>
				<tr>
					<td>
						Integritas  </td>
					<td class="text-center"><?php echo $lastSkp->integritas ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($lastSkp->integritas) ?>)</td>

				</tr>
				<tr>
					<td>
						komitmen  </td>
					<td class="text-center"><?php echo $lastSkp->komitmen ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($lastSkp->komitmen) ?>)</td>

				</tr>
				<tr>
					<td>
						Disiplin  </td>
					<td class="text-center"><?php echo $lastSkp->disiplin ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($lastSkp->disiplin) ?>)</td>

				</tr>
				<tr>
					<td>
						Kerjasama  </td>
					<td class="text-center"><?php echo $lastSkp->kerjasama ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($lastSkp->kerjasama) ?>)</td>

				</tr>
				<tr>
					<td>
						Kepemimpinan  </td>
					<td class="text-center"><?php echo $lastSkp->kepemimpinan ? $lastSkp->kepemimpinan : "-" ?></td>
					<td class="text-center"><?php echo $lastSkp->kepemimpinan ? "(".$skp->sebutan_capaian($lastSkp->kepemimpinan).")" : "-" ?></td>

				</tr>
				<tr>
					<td>
						JUMLAH  </td>
					<td class="text-center"><?php echo $lastSkp->jumlah_perilaku ?></td>
					<td></td>

				</tr>
				<tr>
					<td>
						Nilai Rata-rata </td>
					<td class="text-center"><?php echo number_format($lastSkp->rata2_perilaku,2) ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($lastSkp->rata2_perilaku) ?>)</td>
				</tr>
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

	$("#btnPerilaku").on("click",function(){

		$.post("skp.php", $("#perilakuForm").serialize())
		.done(function(data){
			//alert(data);
			window.location.reload();
		});

	});



</script>
<script src="skp.js"></script>
