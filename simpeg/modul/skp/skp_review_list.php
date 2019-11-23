<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Daftar SKP</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">LIST REVIEW SASARAN KERJA <br> PEGAWAI NEGERI SIPIL</h5>
	</div>
	<div class="panel-body table-responsive">
		<table class="clearfix table table-bordered" id="listskp">
			<thead>
				<tr>
					<th>No.</th>
					<th>Periode</th>
					<th>Pejabat Penilai</th>
					<th>Atasan Pejabat Penilai</th>
					<th>Nilai</th>
					<th class="hidden-print">Review</th>
				</tr>				
			</thead>
			<tbody>
				<?php
					$list_skp = $skp->get_skp($_GET['idp']);
					$x=1;
					while($each_skp = mysql_fetch_object($list_skp)){
				?>
				<tr>
					<td><?php echo $x++; ?>.</td>
					<td><?php echo $each_skp->periode_awal." - ".$each_skp->periode_akhir ?></td>
					<td><?php echo $obj_pegawai->get_obj($each_skp->id_penilai)->nama ?></td>
					<td><?php echo $obj_pegawai->get_obj($each_skp->id_atasan_penilai)->nama ?></td>
					<td><span class="text-danger"><?php echo $skp->get_status($each_skp->status_pengajuan)->status ?></span></td>
					<td class="hidden-print">
						<a href="index.php?page=review&idskp=<?php echo $each_skp->id_skp ?>&idp=<?php echo $_GET['idp'] ?>" class="btn btn-primary btn-xs">lihat</a>
						
					</td>
				</tr>
				<?php
					}
				?>					
			</tbody>
		</table>
	</div>
	<div class="panel-footer hidden-print">		
		<a href="#" class="btn btn-info" type="button" onclick="window.print()">cetak</a>		
	</div>	
</div>



<script>
	
	$(document).ready(function(){
	
		$(".in").removeClass("in");
		$("#collapseTwo").addClass("in");			
		
	});
	
</script>
