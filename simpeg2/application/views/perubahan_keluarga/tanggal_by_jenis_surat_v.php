<select name="tanggal_surat" id="tanggal_surat">
	<option value=0>-Pilih Tanggal Surat-</option>
	<?php
		if($tgl->num_rows() > 0)
		{
			foreach($tgl->result() as $r)
			{
	?>
				<option value="<?php echo $r->tgl_perubahan?>"><?php echo $r->tgl_perubahan?></option>
	<?php
			}
		}
		else
		{
	?>
			<option value="">Tidak Ada Data</option>
			
	<?php
		}
	?>
</select>