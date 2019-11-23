<?php
	if($_GET['id_status'] == 9 || $_GET['id_status'] == 10){
?>
<label for="nama" class="col-sm-4 control-label">Status Tunjangan</label>
<div class="col-sm-8" id="dapat_tunjangan">
	<select name="dapat_tunjangan" id="pilih_tunjangan" class="form-control" required>
		<option value="-">-Pilih Status Tunjangan</option>
		<option value=1>Dapat Tunjangan</option>
		<option value=0>Tidak Dapat Tunjangan</option>
	</select>	
</div>
<?php
	}else{
?>
<input type="hidden" value="<?php echo $id_p?>" name="id_pegawai">
		<input type="hidden" value="<?php echo $id_s;?>" id="status_hubungan" name="status_hubungan">
		<div class="form-group">
				<label for="nama" class="col-sm-4 control-label">Nama</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" required>
				</div>
			</div>
			<div class="form-group">
				<label for="tempat_lahir" class="col-sm-4 control-label">Tempat lahir</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Tempat Lahir" name="tempat_lahir" required>
				</div>
			</div>
			<div class="form-group">
				<label for="tgl_lahir" class="col-sm-4 control-label">Tanggal Lahir</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Tanggal Lahir" name="tgl_lahir" id="dp_tgl_lahir"required>
				</div>
			</div>
			<div class="form-group">
				<label for="jk" class="col-sm-4 control-label">Jenis Kelamin</label>
				<div class="col-sm-8">
				<select name="jk" class="form-control" placeholder="jenis Kelamin" required>
					<option>-Pilih Jenis kelamin-</option>
					<option value=1>Laki-laki</option>
					<option value=2>Perempuan</option>
				</select>	
				</div>
			</div>
			<div class="form-group">
				<label for="keterangan" class="col-sm-4 control-label">Keterangan</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="keterangan">
				</div>		
			</div>
			
<?php
	}
?>
<script>
	$('#dp_tgl_lahir').datepicker({
	 autoclose: true,
	 format:"yyyy-mm-dd"
	});
</script>