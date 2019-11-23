<?php

	$perilaku = $skp->get_skp_by_id($_GET['idskp']);

	if(isset($perilaku->id_penilai_realisasi)){
		$penilai = $obj_pegawai->get_obj($perilaku->id_penilai_realisasi);
		//$atasan_penilai = $obj_pegawai->get_obj($perilaku->id_atasan_penilai_realisasi);

	}else{
		$penilai = $obj_pegawai->get_obj($perilaku->id_penilai);
		//$atasan_penilai = $perilaku->get_penilai($penilai);
	}

	$list_skp = $skp->get_skp_by_tahun($pegawai->id_pegawai,'2015');

	if(mysql_num_rows($list_skp) > 0){

	while($each_skp = mysql_fetch_object($list_skp)){
		$nilai[] = $skp->get_nilai_capaian($each_skp->id_skp)->rata2_nilai_skp;

	}}
?>
<div class="hidden-print">
<?php // echo $format->date_dmY($theSkp->periode_awal)." s.d. ".$format->date_dmY($theSkp->periode_akhir)?>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php?page=list">Daftar PPK</a></li>
		<?php $periode = explode('-', $theSkp->periode_awal); ?>
		<li class="breadcrumb-item"><a href="index.php?page=listtabel&idp=<?php echo $_SESSION['id_pegawai'] ?>&tahun=<?php echo $periode[0] ?>"><?php echo $periode[0] ?></a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php  echo $format->date_dmY($theSkp->periode_awal)." s.d. ".$format->date_dmY($theSkp->periode_akhir)?></li>
	</ol>
</nav>
<nav>
	<ol class="cd-multi-steps text-bottom count">
		<li class="visited"><a href="index.php?page=ubah_data&idskp=<?php echo $idskp ?>">Data</a></li>
		<li class="visited"><a href="index.php?page=formulir&idskp=<?php echo $idskp ?>">Target</a></li>
		<li class="visited"><a href="index.php?page=realisasi&idskp=<?php echo $idskp ?>">Realisasi</a></li>
		<li class="visited"><strong>Perilaku</strong></li>
		
	</ol>
</nav>
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
						<?php // echo $format->tanggal_indo($perilaku->periode_akhir)
											$date = DateTime::createFromFormat("Y-m-d", $perilaku->periode_akhir);

											echo $format->tanggal_indo($perilaku->periode_awal)." s.d. <br> ".$format->tanggal_indo($perilaku->periode_akhir)
						?></td>
					<td colspan="3">
						Penilaian SKP sampai dengan <?php echo $format->tanggal_indo($perilaku->periode_akhir) ?> =
						<?php //echo array_sum($nilai) / count($nilai) ?>
						<?php // echo  $skp->get_nilai_capaian_rata2($_SESSION['id_pegawai'], $date->format("Y"),2)
								 echo $skp->get_nilai_capaian($perilaku->id_skp)->rata2_nilai_skp  ?>, <br>
						sedangkan penilaian perilaku kerjanya adalah sebagai berikut:
					</td>
					<td rowspan="9" style="vertical-align:middle" class="text-center">
						<span><?php
							if(isset($perilaku->jabatan_penilai_realisasi)){
								echo $perilaku->jabatan_penilai_realisasi;
							}else{
								echo $perilaku->jabatan_penilai;
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
					<td class="text-center"><?php echo $perilaku->orientasi_pelayanan ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($perilaku->orientasi_pelayanan) ?>)</td>
				</tr>
				<tr>
					<td>
						Integritas  </td>
					<td class="text-center"><?php echo $perilaku->integritas ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($perilaku->integritas) ?>)</td>

				</tr>
				<tr>
					<td>
						komitmen  </td>
					<td class="text-center"><?php echo $perilaku->komitmen ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($perilaku->komitmen) ?>)</td>

				</tr>
				<tr>
					<td>
						Disiplin  </td>
					<td class="text-center"><?php echo $perilaku->disiplin ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($perilaku->disiplin) ?>)</td>

				</tr>
				<tr>
					<td>
						Kerjasama  </td>
					<td class="text-center"><?php echo $perilaku->kerjasama ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($perilaku->kerjasama) ?>)</td>

				</tr>
				<tr>
					<td>
						Kepemimpinan  </td>
					<td class="text-center"><?php echo $perilaku->kepemimpinan ? $perilaku->kepemimpinan : "-" ?></td>
					<td class="text-center"><?php echo $perilaku->kepemimpinan ? "(".$skp->sebutan_capaian($perilaku->kepemimpinan).")" : "-" ?></td>

				</tr>
				<tr>
					<td>
						JUMLAH  </td>
					<td class="text-center"><?php echo $perilaku->jumlah_perilaku ?></td>
					<td></td>

				</tr>
				<tr>
					<td>
						Nilai Rata-rata </td>
					<td class="text-center"><?php echo number_format($perilaku->rata2_perilaku,2) ?></td>
					<td class="text-center">(<?php echo $skp->sebutan_capaian($perilaku->rata2_perilaku) ?>)</td>
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
