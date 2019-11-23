<?php 
	
	$sql = "SELECT f.*, jm.nama_jfu,						
					IF(bp.bidang is not null, bp.bidang, 'SEMUA JURUSAN')as bidang_pendidikan
				
				from formasi f
				inner join jfu_master jm on jm.id_jfu = f.id_jfu
				left join bidang_pendidikan bp on bp.id = f.id_bidang_pendidikan 
				where id_unit_kerja = 4216";
				
	$query = mysql_query($sql);
	
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h5>Kebutuhan Formasi</h5>
	</div>
	<div class="panel-body">
		<table class="table table-bordered" id="table_formasi">
			<thead>
				<tr>	
					<th>JFU</th>
					<th>Jenjang Pendidikan</th>
					<th>Bidang Pendidikan</th>
					<th>Jumlah</th>
					<th>Sedang Proses</th>
					<th>Sisa</th>
				</tr>				
			</thead>
			<tbody>
				<?php while($formasi  = mysql_fetch_object($query)) { 
				 
						$q = "select count(*) as jumlah from ijin_belajar 
								where id_formasi = ".$formasi->id_formasi;
							
						$_q = mysql_query($q);
						
						if($_q){
							$_jumlah_proses =  mysql_fetch_object($_q)->jumlah;
						}else{
							$_jumlah_proses = 0;
						}
						
						$sisa = $formasi->jumlah_kebutuhan - $_jumlah_proses;
						if($sisa > $formasi->jumlah_kebutuhan){
							$context = "danger";
						}else if($sisa < $formasi->jumlah_kebutuhan){
							$context = "success";
						}else{
							$context = "";
						}
				?>
				<tr class="<?php echo $context ?>">		
					<td><?php echo $formasi->nama_jfu ?></td>
					<td><?php
							switch($formasi->syarat_pendidikan) {
								case 1:
									echo "S3";
									break;
								case 2:
									echo "S2";
									break;
								case 3:
									echo "S1";
									break;
								case 4:
									echo "D3";
									break;
								default:
									echo "Undefined";
							}
						?>
					</td>
					<td><?php echo $formasi->bidang_pendidikan ?></td>
					<td><?php echo $formasi->jumlah_kebutuhan ?></td>					
					<td><?php echo $_jumlah_proses ?></td>
					<td><?php echo $formasi->jumlah_kebutuhan - $_jumlah_proses; ?>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<script>
	$(document).ready(function(){
		
		$("#table_formasi").dataTable({
			
		});
		
		$("#need").addClass("active");
		$("#add").removeClass("active");
		$("#list").removeClass("active");
	});
</script>