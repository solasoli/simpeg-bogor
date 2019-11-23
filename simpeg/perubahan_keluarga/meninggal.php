<?php
	$ket = $_POST['keterangan'];
	
	if($ket == "meninggal")
	{
?>
		<label class="col-sm-4 control-label">Tanggal Meninggal</label>
		<div class="col-sm-8">
			<input type="text" name="tanggal_meninggal" id="tanggal_meninggal" class="form-control" placeholder="Tanggal Meninggal" required>
		</div>
		<br/></br/></br/>
		<label for="inputPassword3" class="col-sm-4 control-label">Akte Meninggal</label>
		<div class="col-sm-8">
			<input type="text" name="akte_meninggal" class="form-control" required>
		</div>
<?php
	}
	else if($ket=="cerai")
	{
		
?>
		<label class="col-sm-4 control-label">Tanggal Cerai</label>
		<div class="col-sm-8">
			<input type="text" name="tanggal_cerai" id="tanggal_cerai" class="form-control" placeholder="Tanggal Cerai" required>
		</div>
			<br/></br/></br/>
		<label for="inputPassword3" class="col-sm-4 control-label">Akte Cerai</label>
		<div class="col-sm-8">
			<input type="text" name="akte_cerai" class="form-control" required>
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