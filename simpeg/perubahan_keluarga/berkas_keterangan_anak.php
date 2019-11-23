<h4>Unggah Berkas</h4>
<?php
	$ket = $_POST['keterangan'];
	
	if($ket == "meninggal")
	{
?>
<div class="form-group" id="surat_kematian">
	<label class="col-sm-8 control-label">1. Surat Kematian</label>
	<div class="col-sm-8">
		<input type="file" class="form-control" name="ufile_mati[]" <!--required-->>
	</div>
</div>
<?php
	}
	else if($ket=="bekerja")
	{
		
?>
<div class="form-group" id="surat_bekerja">
	<label class="col-sm-8 control-label">1. Surat Keterangan Telah Bekerja</label>
	<div class="col-sm-8">
		<input type="file" class="form-control" name="ufile_bekerja[]" <!--required-->>
	</div>
</div>

<?php
	}
	else if($ket==0)
	{
?>
	<div></div>
<?php
	}
?>