<div style="margin-left:10%;margin-right:40%">
<br/>
<h4>Silahkan Lengkapi Berkas</h4>
<br/>
<form method="POST" action="<?php echo base_url()?>perubahan_keluarga/upload_lengkapi_berkas_suami_istri/<?php echo $this->uri->segment(3);?>" enctype="multipart/form-data">
<label>1.Fotokopi Surat Nikah</label><br/>
<div class="input-control file">
	<input type="file" name="ufile_si[]"/>
	<button class="btn-file"></button>
</div>
<button>Simpan</button>
</form>
</div>