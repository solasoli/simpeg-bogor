<div class="container">
	<h2>Form Pengurangan Jiwa</h2>
	<hr/>
	<?php 
		if($keluarga_by_id->num_rows() > 0)
			$r = $keluarga_by_id->row(); 
	?>
	
	<form method="POST" action="<?php echo base_url()?>perubahan_keluarga/update_pengurangan_jiwa/<?php echo $this->uri->segment(3);?>/<?php echo $r->id_status;?>/<?php echo $r->id_pegawai;?>" enctype="multipart/form-data">
		<div class="grid">
			<div class="row">
				<div class="span8">
					<h5 style="margin-left:5%;">Data Keluarga</h5>
					<br/>
		
					<div style="margin-left:5%;">
					<table>
						<tr>
								<td width="200px">Ubah Status</td>
								<td width="18px">:</td>
								<td width="220px">
									<div class="input-control select">
										<select id="pilih_status" name="pilih_status">
											<option value=-1>Tidak Dapat Tunjangan</option>
										</select>
									</div>
								</td> 
						</tr>
						<tr>
							<td width="200px">Keterangan </td>
								<td width="18px">:</td>
								<td width="220px">
									<div class="input-control select">
										<select id="pilih_keterangan" name="pilih_keterangan">
											<option value=0>-Pilih Keterangan-</option>
											<option value="meninggal">Meninggal</option>
											<?php
												if($this->uri->segment(4) == 9)
												{
											?>
													<option value="cerai">Cerai</option>
											<?php 
												}
												if($this->uri->segment(4) == 10)
												{
											?>
												<option value="bekerja">Telah Bekerja</option>
											<?php
												}
											?>
										</select>
									</div>
								</td> 
						</tr>
						<tr>
							<td width="200px"></td>
							<td width="18px"></td>
						</tr>
					</table>
				</div>	
				
				<!--Keterangan Meninggal -->
				<div class="span8" id="hasil_keterangan">
							
				</div>
			</div>
				
				<div class="span5" id="hasil_berkas" >
					
					<div>
					</div>
				</div>
			</div>
		</div>
			
				<div style="margin-left:2%;">
					&nbsp;&nbsp;&nbsp;
					<button class="button primary" id="simpan">Simpan</button>
					<a class="button" href="<?php echo base_url()?>perubahan_keluarga/data_pegawai_by_id/<?php echo $this->uri->segment(5);?>">Batal</a>	
				</div>
</form>
</div>
<script>
$(document).ready(function(){
	
	$('#pilih_keterangan').change(function(){
			$.ajax({
				type : "POST",
				url  : "<?php echo base_url().'perubahan_keluarga/load_keterangan_pengurangan'?>",
				data : "ket=" + $('#pilih_keterangan').val(),
				success: function(data){
					$('#hasil_keterangan').html(data);
					
					$('#dp_tanggal_meninggal').datepicker({
						format : "yyyy-mm-dd"
					});
					
					$('#dp_tanggal_cerai').datepicker({
						format : "yyyy-mm-dd"
					});
				}
			});
		});
		
		$('#pilih_keterangan').change(function(){
				$.ajax({
				type : "POST",
				url  : "<?php echo base_url().'perubahan_keluarga/load_berkas_pengurangan'?>",
				data : "ket=" + $('#pilih_keterangan').val(),
				success: function(data){
					$('#hasil_berkas').html(data);
				}
			});
		});
	
	// $('#ket_lainnya').hide();
	// $('#ket_meninggal').hide();
	// $('#ket_cerai').hide();
	// $('#lb_sk').hide();
	// $('#in_sk').hide();
	// $('#lb_sc').hide();
	// $('#in_sc').hide();
	// $('#pilih_keterangan').change(function(){
		// var cek  = $('#pilih_keterangan').val();
		
		// if(cek=="lainnya")
		  // {
			// $('#ket_lainnya').show();  
		  // }
		 // else if(cek=="meninggal")
		 // {
			 	// $('#ket_lainnya').hide();
				// $('#ket_meninggal').show()
				// $('#lb_sk').show();
				// $('#in_sk').show();
				// $("#dp_tanggal_meninggal").datepicker({
				 // format: "yyyy-mm-dd"
			    // });
		 // }
		 // else if(cek=="cerai")
		 // {
			// $('#ket_lainnya').hide();
			// $('#ket_cerai').show();
			// $('#lb_sc').show();
			// $('#in_sc').show();
			// $("#dp_tanggal_cerai").datepicker({
				 // format: "yyyy-mm-dd"
			    // });
		 // }
		
	// });
	
});
</script>