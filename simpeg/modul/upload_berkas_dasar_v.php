<?php

include('class/keluarga_class.php');
$keluarga = new Keluarga_class;

?>
<form action="pk_upload_berkas_dasar.php?od=<?php echo $od?>" method="POST" enctype="multipart/form-data">
<h2>Berkas Dasar Pegawai</h2>
<hr/>
<?php
	$rs = $keluarga->get_berkas_dasar_pegawai($od);
?>
<p><b>Tanggal Terakhir Update Berkas : <?php 
						if(mysql_num_rows($rs) > 0)
						{
							$row = mysql_fetch_object($rs);
							echo $row->tgl_update;
						}
						else
						{
							echo "-";
						}
						?>
</b></p>
<br/>
<input type="hidden" value="<?php echo $od;?>" name="id_pegawai">
	<div class="form-group">
		<label class="col-sm-4 control-label">1. Surat Pengantar dari Unit Kerja</label>
		<div class="col-sm-6">
			<input type="file" class="form-control" name="ufile[]" required>
		</div>
	</div>
	
	<br/><br/>
	<div class="form-group">
		<label class="col-sm-4 control-label">2. Fotokopi SK Pangkat Terakhir</label>
		<div class="col-sm-6">
				<input type="file" class="form-control" name="ufile[]" required>
		</div>
	</div>
	
	<br/><br/>
	<div class="form-group">
		<label class="col-sm-4 control-label">3. Fotokopi SKUM-PTK &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
		<div class="col-sm-6">
				<input type="file" class="form-control" name="ufile[]" required>
		</div>
	</div>
	
	<br/><br/>
	<div class="form-group">
		<label class="col-sm-4 control-label">4. Fotokopi Daftar Gaji Bulan Terakhir </label>
		<div class="col-sm-6">
			<input type="file" class="form-control" name="ufile[]" required>
		</div>
	</div>
	<br/><br/>
	<div class="form-group">
		<button class="btn btn-primary btn-sm">Unggah</button>
		<a href="index3.php?x=box.php&od=<?php echo $od ?>" class="btn btn-default btn-sm">Kembali</a>
	</div>
</form>