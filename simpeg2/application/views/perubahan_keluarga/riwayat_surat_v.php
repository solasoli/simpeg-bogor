<div style="margin-left:10%">
	<h2>Riwayat Surat</h2>
	<hr/>
	<form method="post">
		<div class="grid">
			<div class="row">
				<div class="span3">
					<label>Jenis Surat &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </label><br/>
					<label id="lb_tgl_surat">Silahkan Pilih Tanggal Surat &nbsp;&nbsp;&nbsp; : </label>
				</div>
				<input type="hidden" id="id_pegawai" name="id_pegawai" value="<?php echo $this->uri->segment(3);?>"/>
				<div class="span4">
						<div class="input-control select">			
							<select name="jenis_surat" id="jenis_surat">
								<option value=0>-Pilih Jenis Surat-</option>
								<option value=1>Penambahan</option>
								<option value=-1>Pengurangan</option>
							</select>
						</div>
						<br/><br/>
						<div class="input-control select" >			
							<select name="tanggal_surat" id="mySelect">
								<option value=0>-Pilih Tanggal Surat-</option>
							</select>
						</div>
				</div>
				<div class="span3">
					<br/><br/><br/>
					<button class="button primary" id="lihat_surat" type="submit">Lihat Surat</button>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
$(document).ready(function(){
	$('#lb_tgl_surat').hide();
	$('#lihat_surat').hide();
	$('#mySelect').hide();
	
	$('#jenis_surat').change(function(){
		var jenis_surat = $('#jenis_surat').val();
		$.ajax({
			type : "post",
			url  : "<?php echo base_url()?>perubahan_keluarga/get_tanggal_by_jenis_surat",
			data : "jenis_surat=" + $('#jenis_surat').val() +"&id_pegawai="+$('#id_pegawai').val(),
			success: function(data){
				$('#lb_tgl_surat').show();
				$('#lihat_surat').show();
				$('#mySelect').html(data);
				$('#mySelect').show();
				
			}
		});
	});
	
	$('#tanggal_surat').change(function(){
		window.location = '<?php echo base_url();?>perubahan_keluarga/get_tanggal_by_jenis_surat';
	});
});
</script>