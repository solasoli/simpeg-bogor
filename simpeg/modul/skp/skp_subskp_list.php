<?php
	$sub = $obj_pegawai->get_obj($_GET['idp']);
?>
<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Daftar Penilaian Prestasi <?php echo $sub->nama ?></h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">DAFTAR PENILAIAN PRESTASI<br> PEGAWAI NEGERI SIPIL</h5>
	</div>
	<div class="panel-body table-responsive">
		<table class="clearfix table table-bordered" id="listskp">
			<thead>
				<tr>
					<th class="text-center">No.</th>
					<th class="text-center">Periode</th>
					<th class="text-center">Pejabat Penilai</th>
					<th class="text-center">Atasan Pejabat Penilai</th>
					<th class="text-center">Status SKP</th>
					<th class="hidden-print">Review</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$list_skp = $skp->get_skp_dinilai($_GET['idp']);
					$x=1;

					if(mysqli_num_rows($list_skp) > 0){

					while($each_skp = mysqli_fetch_object($list_skp)){
				?>
				<tr>
					<td><?php echo $x++ ;  ?>.</td>
					<td><?php echo $format->tanggal_indo($each_skp->periode_awal)." s.d ".$format->tanggal_indo($each_skp->periode_akhir) ?></td>
					<td><?php echo $obj_pegawai->get_obj($each_skp->id_penilai)->nama_lengkap ?></td>
					<td><?php echo $obj_pegawai->get_obj($each_skp->id_atasan_penilai)->nama_lengkap ?></td>
					<td><span class="text-danger"><?php echo $skp->get_status($each_skp->status_pengajuan)->status ?></span></td>
					<td class="hidden-print">
						<a href="index.php?page=<?php echo $_GET['t']?>&idskp=<?php echo $each_skp->id_skp ?>&idp=<?php echo $_GET['idp'] ?>" class="btn btn-primary btn-xs">lihat</a>

					</td>
				</tr>
				<?php
					}}else{
						echo "<tr><td colspan='6' class='danger text-center'>tidak ada skp yang ditemukan</td></tr>";
					}
				?>
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
		$("#collapseTwo").addClass("in");

	});

</script>
<script src="skp.js"></script>
