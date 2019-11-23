<?php
require_once("../../library/format.php");
require_once "../../class/pegawai.php"; 
require "skp.php";

$skp = new Skp;	
$format = new Format;
$obj_pegawai = new Pegawai;

$theSkp = $skp->get_skp_by_id($_POST['idskp']);
$pegawai = $obj_pegawai->get_obj($theSkp->id_pegawai);
$penilai = $obj_pegawai->get_obj($theSkp->id_penilai);
?>
<table class="table col-lg-4">
	<tr>
		<th>Nama Pegawai</th>
		<td width="1%">:</td>
		<td><?php echo $pegawai->nama_lengkap ?></td>
		<th>Nama Penilai</th>
		<td width="1%">:</td>
		<td><?php echo $penilai->nama_lengkap ?></td>
	</tr>
	<tr>
		<th>NIP</th>
		<td width="1%">:</td>
		<td><?php echo $pegawai->nip_baru ?></td>
		<th>NIP</th>
		<td width="1%">:</td>
		<td><?php echo $penilai->nip_baru ?></td>
	</tr>
	<tr>
		<th>Jabatan</th>
		<td width="1%">:</td>
		<td><?php echo $theSkp->jabatan_pegawai ?></td>
		<th>Jabatan</th>
		<td width="1%">:</td>
		<td><?php echo $theSkp->jabatan_penilai ?></td>
	</tr>
	<tr>
		<th>Periode</th>
		<td width="1%">:</td>
		<td colspan="4" ><?php echo $format->tanggal_indo($theSkp->periode_awal)." s/d ".$format->tanggal_indo($theSkp->periode_akhir) ?></td>
	</tr>
	<tr>
		<th>Status PPK</th>
		<td width="1%">:</td>
		<td colspan="4" ><?php echo $skp->get_status($theSkp->status_pengajuan)->status ?></td>
	</tr>
</table>
<table class="clearfix table table-bordered">
			
<tr>
	<td rowspan="2" class="text-center">NO</td>
	<td rowspan="2" class="text-center">I. KEGIATAN TUGAS</td>
	<td rowspan="2" class="text-center">AK</td>	
	<td colspan="4" class="text-center">TARGET</td>
	<td rowspan="2" class="text-center">AK</td>
	<td colspan="4" class="text-center">REALISASI</td>
	<td class="text-center" rowspan="2">PENGHI-<br>TUNGAN</td>
	<td class="text-center" rowspan="2">NILAI <br>CAPAIAN SKP</td>	
</tr>
<tr>
	<!-- target -->
	<td>Kuantitas</td>
	<td>Kualitas</td>
	<td>Waktu</td>
	<td>Biaya</td>
	<!-- end target -->
	<!-- realisasi -->
	<td>Kuantitas</td>
	<td>Kualitas</td>
	<td>Waktu</td>
	<td>Biaya</td>
	<!-- end of realisasi -->	
</tr>
<!-- ini baris uraian tugas -->
<?php
	$list_target = $skp->get_target($_POST['idskp']);
	$x = 1;
	while($target = mysql_fetch_object($list_target)){
		if($result = $skp->get_target_history($target->id_skp_target)){
			$history = mysql_fetch_object($result);
		}else
			$history = "";
?>
<tr >
	<td><?php echo $x++ ?></td>
	<td>
		<span <?php if(($target->kuantitas == 0) && ($target->kualitas == 0)) echo "style='text-decoration:line-through'" ?>>
		<?php echo $target->uraian_tugas ?>
		</span>
	</td>
	<td class="text-center"><?php echo $target->angka_kredit ?></td>
	<td class="text-center">
		<?php 
			if($history != "" ) echo "<span style='text-decoration:line-through'>".$history->kuantitas."</span><br>" ;
			echo $target->kuantitas." ".$target->kuantitas_satuan 
		?>
	</td>
	<td class="text-center">
		<?php 
			if($history != "" ) echo "<span style='text-decoration:line-through'>".$history->kualitas."</span><br>" ;
			echo $target->kualitas
		?> %
	</td>
	<td class="text-center">
		<?php 
			if($history != "" ) echo "<span style='text-decoration:line-through'>".$history->waktu."</span><br>" ;
			echo $target->waktu." ".$target->waktu_satuan 
		?>
	</td>
	<td class="text-center">
		<?php 
			if($history != "" ) echo "<span style='text-decoration:line-through'>".$format->currency($history->biaya)."</span><br>" ;
			echo $format->currency($target->biaya)
		?>
	</td>
	<!-- end of target -->
	<!-- realisasi -->
	<td class="text-center"><?php echo $target->real_angka_kredit ?></td>
	<td class="text-center"><?php echo $target->real_kuantitas." ".$target->kuantitas_satuan ?></td>
	<td class="text-center"><?php echo $target->real_kualitas?> %</td>
	<td class="text-center"><?php echo $target->real_waktu." ".$target->waktu_satuan ?></td>
	<td class="text-center"><?php echo $format->currency($target->real_biaya) ?></td>
	<td class="text-center"><?php echo $target->hitung_nilai ?></td>
	<td class="text-center"><?php echo $target->nilai_capaian ?></td>	
</tr>
<?php } ?>
