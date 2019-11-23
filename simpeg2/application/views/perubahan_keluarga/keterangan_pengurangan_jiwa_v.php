<!--Meninggal-->
<?php
	if($ket == 'meninggal')
	{
?>
		<table cellpadding="10px">
		<tr>
			<td width="200px">Tanggal Meninggal</td>
			<td width="20px">:</td>
			<td>
				<div height="10px" class="input-control text" id="dp_tanggal_meninggal">
					<input type="text" name="tanggal_meninggal">
						<a class="btn-date"></a>
				</div>
			</td>
		</tr>
		<tr>
			<td>Akte Meninggal</td>
			<td>:</td>
			<td>
				<div class="input-control text">
					<input type="text" name="akte_meninggal"/>
				</div>
			</td>
		</tr>

		</table>		
<?php
	}
	else if($ket == 'cerai')
	{
?>
		<table cellpadding="10px">
		<tr>
			<td width="200px">Tanggal Cerai</td>
			<td width="20px">:</td>
			<td>
				<div height="10px" class="input-control text" id="dp_tanggal_cerai">
					<input type="text" name="tanggal_meninggal">
					<a class="btn-date"></a>
				</div>
			</td>
		</tr>
		<tr>
			<td>Akte Cerai</td>
			<td>:</td>
			<td>
				<div class="input-control text">
					<input type="text" name="akte_cerai"/>
				</div>
			</td>
		</tr>
		</table>	
<?php
	}
?>	