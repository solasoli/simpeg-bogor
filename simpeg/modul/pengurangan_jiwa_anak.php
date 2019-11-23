<div style="margin-left:3%;margin-right:3%;">
<h3>Form Pengurangan Jiwa Anak </h3>
<hr/>
<form method="POST" action="pk_pengurangan_jiwa.php" enctype="multipart/form-data">

<!--Input type hidden-->
<input type="hidden" name="id_status" value="<?php echo $id_status;?>">
<input type="hidden" name="id_keluarga" value="<?php echo $id_kel;?>">
<input type="hidden" name="id_pegawai" value="<?php echo $id_peg;?>">

<div class="row">
	<div class="col-md-6">
	<h4>Data Keluarga</h4>
		 <div class="form-group">
					<label for="inputEmail3" class="col-sm-4 control-label">Status Tunjangan</label>
					<div class="col-sm-8">
					  <select class="form-control" name="status_tunjangan">
						<option value=-2>Tidak Dapat Tunjangan</option>
					  </select>
					</div>
			  </div>
			  <br/><br/><br/>
			  <div class="form-group">
					<label for="inputPassword3" class="col-sm-4 control-label">Keterangan</label>
					<div class="col-sm-8">
						<select class="form-control" name="keterangan" id="keterangan">
							<option value=0>-Pilih Keterangan-</option>
							<option value="meninggal">Meninggal</option>
							<option value="bekerja">Telah Bekerja</option>
						</select>
					</div>
			  </div>
			  <br/><br/>
			  <div class="form-group" id="hasil">
					
			  </div>
			 <br/><br/>
			    <div class="form-group">
					<div class="col-sm-2">
						<button class="btn btn-primary btn-md">Simpan</button>
					</div>
					<div class="col-sm-3">
						<a class="btn btn-default btn-md" href="index3.php?x=box.php&od=<?php echo $id_peg?>">Kembali</a>
					</div>
			  </div>
	</div>				
	
		
	<div class="col-md-6" id="berkas">

	</div>
	</div>

</div>
</form>
</div>
<script>
$(document).ready(function(){
	$('#surat_kematian').hide();
	$('#surat_bekerja').hide();
	$('#keterangan').change(function(){
		$.ajax({
				type : "POST",
				url  : "perubahan_keluarga/keterangan_anak.php",
				data : "keterangan="+$('#keterangan').val(),
				success: function(data){
					$('#hasil').html(data);
					$('#tanggal_meninggal').datepicker({
						format: "yyyy-mm-dd",
						autoclose:true
					});
				}
			});
			$.ajax({
				type : "POST",
				url  : "perubahan_keluarga/berkas_keterangan_anak.php",
				data : "keterangan="+$('#keterangan').val(),
				success: function(data){
					$('#berkas').html(data);
				}
			});
		});
	
});
</script>