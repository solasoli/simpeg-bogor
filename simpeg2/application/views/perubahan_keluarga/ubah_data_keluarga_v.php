<div class="container">
<h3>Ubah Data Keluarga </h3>
<hr/>
<?php
	$r = $kel_all->row();
?>
<form method="POST" action="<?php echo base_url()?>perubahan_keluarga/update_data_keluarga/<?php echo $r->id_keluarga?>/<?php echo $r->id_pegawai?>" enctype="multipart/form-data">
<?php
	if($this->uri->segment(5) == 9)
	{
?>
<table>
<input type="hidden" value="<?php echo $r->id_status?>" name="id_status" id="status">
<input type="hidden" value="<?php echo $r->id_pegawai?>" id="id_pegawai">
<tbody>
	<tr>
		<td width="150px">Nama</td>
		<td width="20px">:</td>
		<td>
			<div height="10px" class="input-control text">
				<input type="text" name="nama" value="<?php echo $r->nama?>" class='size10' required>
			</div>
		</td>
	</tr>
	<tr>
		<td>Tempat Lahir</td>
		<td>:</td>
		<td>
			<div height="10px" class="input-control text">
				<input type="text" name="tempat_lahir" value="<?php echo $r->tempat_lahir?>"  required>
			</div>
		</td>
	</tr>
	<tr>
		<td>Tanggal Lahir</td>
		<td>:</td>
		<td>
			<div height="10px" class="input-control text" id="dp_tanggal_lahir">
				<input type="text" name="tanggal_lahir" value="<?php echo $r->tgl_lahir?>"  required>
				<a class="btn-date"></a>
			</div>
		</td>
	</tr>
	<tr>
		<td>Tanggal Menikah</td>
		<td>:</td>
		<td>
			<div height="10px" class="input-control text" id="dp_tanggal_menikah">
				<input type="text" name="tanggal_menikah" value="<?php echo $r->tgl_menikah?>"  required>
				<a class="btn-date"></a>
			</div>
		</td>
	</tr>
	<tr>
		<td>Akte Menikah</td>
		<td>:</td>
		<td>
			<div height="10px" class="input-control text">
				<input type="text" name="pekerjaan" value="<?php echo $r->akte_menikah?>">
			</div>
		</td>
	</tr>
	<tr>
		<td>Pekerjaan</td>
		<td>:</td>
		<td>
			<div height="10px" class="input-control text">
				<input type="text" name="pekerjaan" value="<?php echo $r->pekerjaan?>">
			</div>
		</td>
	</tr>
	<tr>
		<td>Jenis Kelamin</td>
		<td>:</td>
		<td>
			<div height="10px" class="input-control select">
				<?php
					$jekel = $r->jk;
					if($jekel == 1)
					{
				?>
						<select name="jenis_kelamin">
							<option value=1>Laki-laki</option>
							<option value=2>Perempuan</option>
						</select>
				<?php
					}
					else if($jekel == 2)
					{
				?>
						<select name="jenis_kelamin">
							<option value=2>Perempuan</option>
							<option value=1>Laki-laki</option>
						</select>
				<?php
					}
				?>
			</div>
		</td>
	</tr>
	<?php
		if($r->dapat_tunjangan == 0 AND ($r->id_status == 10 OR $r->id_status == 9))
		{
	?>
			<tr>
				<td>Dapat Tunjangan</td>
				<td>:</td>
				<td>
					<div height="10px" class="input-control select">
						<select name="dapat_tunjangan_1" id="dapat_tunjangan">
							<option value=0>Tidak Dapat Tunjangan</option>
							<option value=1>Dapat Tunjangan</option>
						</select>
					</div>
				</td>
			</tr>
	<?php
		}
		else if($r->dapat_tunjangan == 1 AND ($r->id_status == 10 OR $r->id_status == 9))
		{
	?>
			<tr id="dt_1">
				<td>Dapat Tunjangan</td>
				<td>:</td>
				<td>
					<div height="10px" class="input-control select" >
						<select name="dapat_tunjangan" id="dapat_tunjangan">
							<option value=1>Dapat Tunjangan</option>
							<option value=0>Tidak Dapat Tunjangan</option>
						</select>
					</div>
				</td>
			</tr>
	<?php
		}
	?>
	<tr>
		<td id="hasil_berkas" colspan="3"></td>
	</tr>
</tbody>
<br/>
</table>
<?php
	}
	else
	{
?>
<table>
<input type="hidden" value="<?php echo $r->id_status?>" name="id_status" id="status">
<input type="hidden" value="<?php echo $r->id_pegawai?>" id="id_pegawai">
<tbody>
	<tr>
		<td width="150px">Nama</td>
		<td width="20px">:</td>
		<td>
			<div height="10px" class="input-control text">
				<input type="text" name="nama" value="<?php echo $r->nama?>" class='size10' required>
			</div>
		</td>
	</tr>
	<tr>
		<td>Tempat Lahir</td>
		<td>:</td>
		<td>
			<div height="10px" class="input-control text">
				<input type="text" name="tempat_lahir" value="<?php echo $r->tempat_lahir?>"  required>
			</div>
		</td>
	</tr>
	<tr>
		<td>Tanggal Lahir</td>
		<td>:</td>
		<td>
			<div height="10px" class="input-control text" id="dp_tanggal_lahir">
				<input type="text" name="tanggal_lahir" value="<?php echo $r->tgl_lahir?>"  required>
				<a class="btn-date"></a>
			</div>
		</td>
	</tr>
	<tr>
		<td>Pekerjaan</td>
		<td>:</td>
		<td>
			<div height="10px" class="input-control text">
				<input type="text" name="pekerjaan" value="<?php echo $r->pekerjaan?>">
			</div>
		</td>
	</tr>
	<tr>
		<td>Jenis Kelamin</td>
		<td>:</td>
		<td>
			<div height="10px" class="input-control select">
				<?php
					$jekel = $r->jk;
					if($jekel == 1)
					{
				?>
						<select name="jenis_kelamin">
							<option value=1>Laki-laki</option>
							<option value=2>Perempuan</option>
						</select>
				<?php
					}
					else if($jekel == 2)
					{
				?>
						<select name="jenis_kelamin">
							<option value=2>Perempuan</option>
							<option value=1>Laki-laki</option>
						</select>
				<?php
					}
				?>
			</div>
		</td>
	</tr>
	<?php
		if($r->dapat_tunjangan == 0 AND ($r->id_status == 10 OR $r->id_status == 9))
		{
	?>
			<tr>
				<td>Dapat Tunjangan</td>
				<td>:</td>
				<td>
					<div height="10px" class="input-control select">
						<select name="dapat_tunjangan_1" id="dapat_tunjangan">
							<option value=0>Tidak Dapat Tunjangan</option>
							<option value=1>Dapat Tunjangan</option>
						</select>
					</div>
				</td>
			</tr>
	<?php
		}
		else if($r->dapat_tunjangan == 1 AND ($r->id_status == 10 OR $r->id_status == 9))
		{
	?>
			<tr id="dt_1">
				<td>Dapat Tunjangan</td>
				<td>:</td>
				<td>
					<div height="10px" class="input-control select" >
						<select name="dapat_tunjangan" id="dapat_tunjangan">
							<option value=1>Dapat Tunjangan</option>
							<option value=0>Tidak Dapat Tunjangan</option>
						</select>
					</div>
				</td>
			</tr>
	<?php
		}
	?>
	<tr>
		<td id="hasil_berkas" colspan="3"></td>
	</tr>
</tbody>
<br/>
</table>

<?php
	}
?>
<br/>
<button class="button primary">Simpan</button>
<a class="button" href="<?php echo base_url()?>perubahan_keluarga/data_pegawai_by_id/<?php echo $this->uri->segment(4)?>">Kembali</a>
</form>
</div>
<script>
	$('#dapat_tunjangan').change(function(){
				$.ajax({
				type : "GET",
				url  : "<?php echo base_url().'perubahan_keluarga/berkas_penambahan'?>",
				data : "hubungan="+ $('#status').val()+'&id_pegawai='+$('#id_pegawai').val()+'&tunjangan='+$('#dapat_tunjangan').val(),
				success: function(data){
					$('#hasil_berkas').html(data);
					
					var flag = $('#status_full').val();
					if(flag == -1)
					{
						alert("Tidak dapat mengubah status tunjangan, silahkan lakukan pengurangan jiwa terlebih dahulu");
						window.location = '<?php echo base_url()?>perubahan_keluarga/data_pegawai_by_id/'+$('#id_pegawai').val();
					}
				}
			});
		});
		
		$('#dt_1').hide();
		
		$('#dp_tanggal_lahir').datepicker({
			format : "yyyy-mm-dd"
		});
		
		$('#dp_tanggal_menikah').datepicker({
			format : "yyyy-mm-dd"
		});
</script>