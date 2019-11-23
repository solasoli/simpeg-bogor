<div style="margin-left:10%;margin-right:40%">
<br/>
<h4>Silahkan Lengkapi Berkas</h4>
<br/>
<form method="POST" action="<?php echo base_url()?>perubahan_keluarga/upload_lengkapi_berkas_anak/<?php echo $this->uri->segment(3);?>/<?php echo $this->uri->segment(4)?>" enctype="multipart/form-data">

<?php
	$i = 1;
	$rw = $cek_umur->row();
	
	if($rw->umur > 21)
	{
?>
		<!--Bagi yang masih kuliah usianya > 21-->
		<label><?php echo $i++?>. Surat Keterangan Kuliah</label><br/>
		<div class="input-control file">
			<input type="file" name="ufile_ak[]" required/>
			<button class="btn-file"></button>
		</div>
<?php
	}
?>
	<br/><br/>
	<button> Simpan</button>
</form>
</div>