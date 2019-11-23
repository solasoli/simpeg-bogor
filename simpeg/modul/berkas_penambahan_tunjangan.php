<?php
	$stat = $_GET['id_status'];
	$tun = $_GET['tunjangan'];
	if($stat == 9 && $tun == 2)
	{
?>
		<div class="form-group" style="margin-left:10%">
			<label class="control-label">1. Fotokopi Akte Menikah</label>
			<br/><br/>
			<input type="file" class="form-control" name="ufile_si[]" required>
		</div>
<?php
	}
	else if($stat == 10 && $tun == 2)
	{
?>
		<div class="form-group" style="margin-left:10%">
			<label class="control-label">1. Fotokopi Akte Kelahiran Anak</label>
			<br/><br/>
			<input type="file" class="form-control" name="ufile_ak[]" required>
		</div>
<?php
	}
?>

	