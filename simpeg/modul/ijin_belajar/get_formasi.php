<?php
	$sql = "SELECT f.*, 						
			jm.nama_jfu,
			IF(bp.bidang is not null, bp.bidang, 'SEMUA JURUSAN')as bidang_pendidikan			
			from formasi f
			inner join jfu_master jm on jm.id_jfu = f.id_jfu
			left join bidang_pendidikan bp on bp.id = f.id_bidang_pendidikan 
			where id_unit_kerja = 4216";
	
	$query = mysql_query($sql);
		
?>
<div class="modal fade" id="modal_choose_formasi" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Formasi yang kosong</h5>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal" id="newskpform">					
					<div class="table-responsive">						
						<table class="table table-bordered" id="tbl_formasi">							
							<thead>
								<tr>
									<th>Pilih</th>
									<th>Formasi</th>
									<th>Jenjang</th>
									<th>Bidang Pendidikan</th>
									<th>Jumlah Kebutuhan</th>
									<th>Existing</th>
									<th>Sedang Proses</th>
									<th>Sisa</th>
								</tr>
							</thead>
							<tbody>
								<?php while($formasi = mysql_fetch_object($query)){ 
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
									<td>
										<input type="radio" class="form-control" <?php echo $sisa <= 0 ? "disabled=disabled" : "" ?> name="radio_jfu" value="<?php echo $formasi->id_formasi?>">
										<input type="hidden" id="<?php echo $formasi->id_formasi?>_jfu" name="<?php echo $formasi->id_formasi?>_jfu" value="<?php echo $formasi->nama_jfu ?>" >
										<input type="hidden" name="<?php echo $formasi->id_formasi?>_syarat" value="<?php echo $formasi->syarat_pendidikan ?>" >
										<input type="hidden" name="<?php echo $formasi->id_formasi?>_bidang" value="<?php echo $formasi->bidang_pendidikan ?>" >
									</td>
									<td><?php echo $formasi->nama_jfu ?></td>
									<td>
										<?php
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
									<td><?php echo $formasi->existing ?>
									<td><?php echo $_jumlah_proses ?></td>
									<td><?php echo $sisa ?>
								</tr>
								<?php } ?>
							</tbody>
						</table>						
					</div>			
					
				</form>
			</div>
			<div class="modal-footer">
				<a  onclick="pilih_jfu()" data-toggle="modal" class="btn btn-primary">PILIH</a>
				<a class="btn btn-danger" data-dismiss="modal">batal</a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function(){
		$("#tbl_formasi").dataTable();
	});
	
	function pilih_jfu(){
		
		id_formasi = $('input[name="radio_jfu"]:checked').val();
		nama_jfu = $('input[name="'+id_formasi+'_jfu"]').val();	
		syarat_jenjang = $('input[name="'+id_formasi+'_syarat"]').val();
		
		
		switch(syarat_jenjang) {
			case "1":
				jenjang = "S3";
				break;
			case "2":
				jenjang = "S2";
				break;
			case "3":
				jenjang = "S1";
				break;
			case "4":
				jenjang = "D-III";
				break;
			default:
				jenjang = "Undefined";
		}
		
		$("#formasi").val(nama_jfu);
		$("#id_formasi").val(id_formasi);
		$("#pl_name").val(jenjang);
		$("#pl").val(syarat_jenjang);
		
		$("#jlanjutan").val( $('input[name="'+id_formasi+'_bidang"]').val());
		$('#modal_choose_formasi').modal('hide');
		
		
	}
</script>