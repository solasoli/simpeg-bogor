<div style="margin-left:10%">
<br/>
<h4>Silahkan pilih jenis surat perubahan keluarga terbaru</h4>
<hr/>
<br/>
<table>
<tr>
	<input type="hidden" name="id_pegawai" id="id_pegawai" value="<?php echo $this->uri->segment(3)?>">
	<td width="200px"><button class="button large" id="tambah">Surat Penambahan</button></td>
	<td><button class="button large" id="kurang">Surat Pengurangan</button></td>
</tr>
</table>
<br/><br/><br/><br/>
</div>
<script>
	$('#tambah').click(function(){
		window.location = '<?php echo base_url();?>perubahan_keluarga/surat_penambahan/'+ $('#id_pegawai').val();
	});
	
	$('#kurang').click(function(){
		window.location = '<?php echo base_url()?>perubahan_keluarga/surat_pengurangan/'+$('#id_pegawai').val();
	});
</script>