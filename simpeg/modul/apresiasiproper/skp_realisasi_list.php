<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Realisasi SKP</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">LIST REALISASI SASARAN KERJA <br> PEGAWAI NEGERI SIPIL</h5>
	</div>
	<div class="panel-body">
		<table class="clearfix table table-bordered" id="listskp">
			<thead>
				<tr>
					<th>No.</th>
					<th>Periode</th>
					<th>Pejabat Penilai Target</th>
					<th>Pejabat Penilai Realisasi</th>
					<th>Status</th>
					<th class="hidden-print">Aksi</th>
				</tr>				
			</thead>
			<tbody>
				<?php
					$list_skp = $skp->get_skp($pegawai->id_pegawai);
					$x=1;
					if(mysql_num_rows($list_skp) > 0){
					while($each_skp = mysql_fetch_object($list_skp)){
				?>
				<tr>
					<td><?php echo $x++; ?>.</td>
					<td><?php echo $format->tanggal_indo($each_skp->periode_awal)." s.d ".$format->tanggal_indo($each_skp->periode_akhir) ?></td>
					<td><?php echo $obj_pegawai->get_obj($each_skp->id_penilai)->nama ?></td>
					<td><?php 
						
						if(isset($each_skp->id_penilai_realisasi)){
							echo $obj_pegawai->get_obj($each_skp->id_penilai_realisasi)->nama;
						}else{
							echo $obj_pegawai->get_obj($each_skp->id_penilai)->nama;
						}
						?>
					</td>
					<td><span class="text-danger"><?php echo $skp->get_status($each_skp->status_pengajuan)->status ?></span></td>
					<td class="hidden-print">
						<a href="index.php?page=realisasi&idskp=<?php echo $each_skp->id_skp ?>" class="btn btn-primary btn-xs">lihat</a>
						
					</td>
				</tr>
				<?php
					}}else{
						echo "<tr class='text-center danger'><td colspan=6>tidak ada skp yang ditemukan</td></tr>";
					}
				?>					
			</tbody>
		</table>
	</div>
	<div class="panel-footer hidden-print">			
		<a href="#" class="btn btn-info" type="button" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></a>		
	</div>	
</div>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div class="modal fade" id="test" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">TEST</div>
			<div class="modal-body">ini body</div>
			<div class="modal-footer">
				<a class="btn btn-danger" data-dismiss="modal">batal</a>
			</div>
		</div>
	</div>
</div>


<script>
	
	$(document).ready(function(){
	
		$(".in").removeClass("in");
		$("#collapseOne").addClass("in");
				
		$("a#hapus").on("click", function(){
						
			idskp = $(this).attr('idskp');
			del = confirm("yakin akan hapus "+idskp);
			if(del == true){				
				$(this).closest('tr').remove();
				$.post("skp.php",{aksi:"delSkp", idskp: idskp});										 
				
			}else{
				alert("kela kela, can yakin yeuh tong waka di apus");
				return false;
			}
		});
		
		
	});
		
</script>
<script src="skp.js"></script>
