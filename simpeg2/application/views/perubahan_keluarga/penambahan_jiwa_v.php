<div class="container">
	<h2>Form Penambahan Jiwa</h2>
	<hr/>
<input type="hidden" name="id_pegawai" id="id_p" value="<?php echo $this->uri->segment(3);?>">
	<form method="POST" action="<?php echo base_url()?>perubahan_keluarga/penambahan_jiwa/<?php echo $this->uri->segment(3);?>" enctype="multipart/form-data">
		<input type="hidden" name="id_pegawai" id="id_pegawai" value="<?php echo $this->uri->segment(3);?>">
		<div class="grid">
			<div class="row">
				<div class="span8">
					<h5 style="margin-left:5%;">Data Keluarga</h5>
					<br/>
					<input type="hidden" name="status_konfirmasi" value=3>
					<div style="margin-left:5%;">
					<table>
						<tr>
								<td width="200px">Hubungan</td>
								<td width="18px">:</td>
								<td width="210px">
									<div style="margin-left:2px" class="input-control select">
										<select id="pilih_hubungan" name="pilih_hubungan">
											<option value=0>-Pilih Hubungan-</option>
											<option value=9>Suami/Istri</option>
											<option value=10>Anak</option>
										</select>
									</div>
								</td> 
						</tr>
						<tr>
									<td>Dapat Tunjangan</td>
									<td>:</td>
									<td>
										<div style="margin-left:2px" class="input-control select">
											<select name="pilih_tunjangan" id="pilih_tunjangan">
												<option value=NULL>-Pilih Tunjangan-</option>
												<option value=1>Dapat Tunjangan</option>
												<option value=0>Tidak Dapat Tunjangan</option>
											</select>
										</div>
									</td>
								</tr>
					</table>
					</div>
					
					<!--Hubungan == 9-->
					<div class="span8" id="hasil_data">
						
					</div>
					</div>
				
				<div class="span5" id="hasil_berkas">
					
					<!--Unggah Berkas Suami/Istri-->
					
				</div>
			</div>
		</div>
			<div class="grid">
				<div class="row">
					<div class="span1">
						<button class="button primary" type="submit">Simpan</button>	
					</div>
					<div class="span1">
						<a class="button" href="<?php echo base_url()?>perubahan_keluarga/data_pegawai_by_id/<?php echo $this->uri->segment(3)?>" id="batal">Kembali</a>
					</div>
				</div>
			</div>
</div>
</form>
<script>
$(document).ready(function(){
	$('#pilih_tunjangan').change(function(){
			$.ajax({
				type : "GET",
				url  : "<?php echo base_url().'perubahan_keluarga/load_data_penambahan'?>",
				data : "hubungan="+ $('#pilih_hubungan').val()+'&id_pegawai='+$('#id_pegawai').val()+'&tunjangan='+$('#pilih_tunjangan').val(),
				success: function(data){
					$('#hasil_data').html(data);
					
					$('#dp_tanggal_lahir').datepicker({
						format : "yyyy-mm-dd"
					});
					
					$('#dp_tanggal_cerai').datepicker({
						format : "yyyy-mm-dd"
					});
					
					$('#dp_tanggal_menikah').datepicker({
						format : "yyyy-mm-dd"
					});
					
					var jumlah = $('#status').val();
				if(jumlah == 2)
				{	
					alert("Tidak Bisa Melakukan Penambahan, Lakukan Pengurangan Jiwa Terlebih Dahulu");
					window.location = '<?php echo base_url()?>perubahan_keluarga/data_pegawai_by_id/'+$('#id_pegawai').val();
				}
				else if(jumlah == 3)
				{
					alert("Tidak Bisa Melakukan Penambahan, Lakukan Pengurangan Jiwa Terlebih Dahulu");
					window.location = '<?php echo base_url()?>perubahan_keluarga/data_pegawai_by_id/'+$('#id_pegawai').val();
				}
				
				}
			});
		});
		
		$('#pilih_tunjangan').change(function(){
				$.ajax({
				type : "GET",
				url  : "<?php echo base_url().'perubahan_keluarga/berkas_penambahan'?>",
				data : "hubungan="+ $('#pilih_hubungan').val()+'&id_pegawai='+$('#id_pegawai').val()+'&tunjangan='+$('#pilih_tunjangan').val(),
				success: function(data){
					$('#hasil_berkas').html(data);
				}
			});
		});
		
		// $('#simpan').click(function(){
			// $.ajax({
				// type : "POST",
				// url  : "<?php echo base_url().'perubahan_keluarga/penambahan_jiwa'?>",
				// data : "hubungan="+ $('#pilih_hubungan').val(),
				// success: function(data){
					// setTimeout(function(){
					// $.Notify({
						// });
					// }, 1000);
				// }
			// });
		// });
});
</script>