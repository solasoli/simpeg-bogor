<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Daftar Pegawai yang dinilai</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">DAFTAR <br> PEGAWAI YANG DINILAI</h5>
	</div>
	<div class="panel-body">
		<table class="clearfix table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>No.</th>
					<th>Nama</th>
					<th>Pangkat/Gol.ruang</th>
					<th>Jabatan</th>					
					<th class="hidden-print">Aksi Review</th>
				</tr>				
			</thead>
			<tbody>
				<?php								
					
					$list_bawahan = $skp->get_dinilai2($pegawai);
					if($list_bawahan){
					$x = 1;
					while($each_bawahan = mysql_fetch_object($list_bawahan)){
					$bawahan = $obj_pegawai->get_obj($obj_pegawai->get_obj($each_bawahan->id_pegawai)->id_pegawai);
				?>				
				<tr>
					<td><?php echo $x++ ?></td>
					<td><?php echo $bawahan->nama_lengkap ?></td>
					<td><?php echo $bawahan->pangkat.' - '.$bawahan->pangkat_gol ?></td>
					<td><?php echo $obj_pegawai->get_jabatan($bawahan) ?></td>
					
					<td class="hidden-print">
						<a href="index.php?page=los&t=<?php echo $_GET['t']?>&idp=<?php echo $bawahan->id_pegawai ?>" class="btn btn-info btn-sm">lihat</a>
					</td>
				</tr>
				<?php }}else{ ?>	
				<tr>
					<td colspan=6 class="text-center danger">Tidak Ditemukan Pegawai yang dinilai</td>
				</tr>
				<?php } ?>			
			</tbody>
		</table>
	</div>
	<div class="panel-footer hidden-print">		
		<a href="#" class="btn btn-info" type="button" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></a>		
	</div>	
</div>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<script>
	
	$(document).ready(function(){
	
		$(".in").removeClass("in");
		$("#collapseTwo").addClass("in");
	});

</script>
<script src="skp.js"></script>
