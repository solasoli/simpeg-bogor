<?php
	$ket = $_POST['keterangan'];
	
	if($ket == "meninggal")
	{
?>
		<label class="col-sm-4 control-label">Tanggal Meninggal</label>
		<div class="col-sm-8">
			<input type="text" name="tanggal_meninggal" id="tanggal_meninggal" placeholder="Tanggal Meninggal" class="form-control" required>
		</div>
		<br/></br/></br/>
		<label for="inputPassword3" class="col-sm-4 control-label">Akte Meninggal</label>
		<div class="col-sm-8">
			<input type="text" name="akte_meninggal" class="form-control" <!--required--> >
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