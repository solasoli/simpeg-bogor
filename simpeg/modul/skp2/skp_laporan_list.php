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
		<h5 class="text-center">DAFTAR PENILAIAN PRESTASI KERJA<br> PEGAWAI NEGERI SIPIL</h5>
	</div>
	<div class="panel-body table-responsive">
		<table class="clearfix table table-bordered" id="listskp">
			<thead>
				<tr>
					<th class="text-center">No.</th>
					<th class="text-center">Periode Penilaian Prestasi Kerja</th>		
					<th class="hidden-print">Review</th>
				</tr>				
			</thead>
			<tbody>
				<?php
					$list_skp = $skp->get_tahun_skp($_GET['idp']);
					$x=1;
					
					if(mysql_num_rows($list_skp) > 0){
					
					while($each_skp = mysql_fetch_object($list_skp)){
				?>
				<tr>
					<td><?php echo $x++ ;  ?>.</td>
					<td><?php echo $each_skp->tahun
						." (".$format->tanggal_indo($skp->get_awal_periode($_GET['idp'], $each_skp->tahun )->awal) 
						." - ".$format->tanggal_indo($skp->get_akhir_periode($_GET['idp'], $each_skp->tahun )->akhir)." )"; 
						?></td>										
					<td class="hidden-print">
						<a href="index.php?page=final2&idp=<?php echo $_GET['idp'] ?>&tahun=<?php echo $each_skp->tahun ?>" class="btn btn-primary btn-xs">lihat</a>
						
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
