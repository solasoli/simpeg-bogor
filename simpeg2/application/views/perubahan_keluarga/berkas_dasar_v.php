<div style="margin-left:10%;margin-right:50%;">
<h2>Berkas Dasar Pegawai</h2>
<br/>
Terakhir Update : <?php 
	if($berkas_dasar->num_rows() > 0)
	{
		$bd = $berkas_dasar->row();
		echo $bd->tgl_update;
	}
	else
	{
		echo "-";
	}
?>
<br/><br/>
<form method="POST" action="<?php echo base_url()?>perubahan_keluarga/upload_berkas_dasar/<?php echo $this->uri->segment(3);?>" enctype="multipart/form-data">
	<label>1. Surat Pengantar Dari Unit Kerja</label><br/>
	<div class="input-control file">
		<input type="file" name="ufile[]" required/>
		<button class="btn-file"></button>
	</div>
	
	<label>2.Fotokopi SK Pangkat Terakhir</label><br/>
	<div class="input-control file">
			<input type="file" name="ufile[]" required/>
			<button class="btn-file"></button>
	</div>
						
	<label>3.Fotokopi SKUM PTK</label><br/>
	<div class="input-control file">
		<input type="file" name="ufile[]" required/>
		<button class="btn-file"></button>
	</div>
						
	<label>4.Fotokopi Daftar Gaji Bulan Terakhir</label><br/>
	<div class="input-control file">
		<input type="file" name="ufile[]" required/>
		<button class="btn-file"></button>
	</div>
	
	<br/><br/>
	<button class="button primary">Unggah</button>
	<a class="button" href="<?php echo base_url()?>perubahan_keluarga/data_pegawai_by_id/<?php echo $this->uri->segment(3)?>">Kembali</a>
</form>
</div>