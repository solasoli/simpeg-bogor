<?php
	include('../konek.php');
	include('../class/keluarga_class.php');
	include('../library/format.php');

	$keluarga = new Keluarga_class;

	$id_s = $_GET['id_status'];
	$id_p = $_GET['id_pegawai'];
	$tun  = $_GET['tunjangan'];

	//$rs_jk = $keluarga->get_jenis_kelamin($id_p);
	//$r 		= mysql_fetch_object($rs_jk);
	$jk 	= @$r->jenis_kelamin;
?>
<?php
	if($id_s == 9 )
	{
		$id_s = 9;


?>
			<input type="hidden" value="<?php echo $id_p;?>" name="id_pegawai">
			<input type="hidden" value="<?php echo $id_s;?>" id="status_hubungan" name="status_hubungan">
			<div class="form-group">
				<label for="nama" class="col-sm-4 control-label">Nama</label>
				<div class="col-sm-8">
						<input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" required />
				</div>
			</div>
			<div class="form-group">
				<label for="tempat_lahir" class="col-sm-4 control-label">Tempat lahir</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Tempat Lahir" name="tempat_lahir" required>
				</div>
			</div>
			<div class="form-group">
				<label for="tgl_lahir" class="col-sm-4 control-label">Tanggal Lahir</label>
				<div class="col-sm-8">
					<input type="text" class="form-control"  placeholder="Tanggal Lahir" name="tgl_lahir" id="dp_tgl_lahir" required>
				</div>
			</div>
			<div class="form-group">
				<label for="tgl_menikah" class="col-sm-4 control-label">Tanggal Menikah</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Tanggal Menikah" name="tgl_menikah" id="dp_tgl_menikah" required>
				</div>
			</div>
			<div class="form-group">
				<label for="tgl_menikah" class="col-sm-4 control-label">Akte Menikah</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Akte Menikah" name="akte_menikah" id="akte_menikah" required>
				</div>
			</div>
			<div class="form-group">
				<label for="tgl_menikah" class="col-sm-4 control-label">No Karsu/Karis</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="No Karsu/Karis" name="no_karsus" id="no_karsus">
				</div>
			</div>
			<div class="form-group">
				<label for="pekerjaan" class="col-sm-4 control-label" >Pekerjaan</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Pekerjaan" name="pekerjaan" required>
				</div>
			</div>
			<div class="form-group">
				<label for="jk" class="col-sm-4 control-label">Jenis Kelamin</label>
				<div class="col-sm-8">
					<select name="jk" class="form-control" placeholder="jenis Kelamin" required>
						<option>-Pilih Jenis kelamin-</option>
						<option value=1 <?php echo $jk == 2? "selected" : ""?>>Laki-laki</option>
						<option value=2 <?php echo $jk == 1? "selected" : ""?>>Perempuan</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="keterangan" class="col-sm-4 control-label">Keterangan</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="keterangan">
					</div>
			</div>

	<?php

	}
	else if($id_s == 10)
	{
		$id_s = 10;
		if($tun == 2)
		{
			$cek = $keluarga->cek_penambahan($id_p, $id_s);
			if(mysql_num_rows($cek) == 2)
			{
				echo "<input type='hidden' value=3 id='status'/>";
			}
			else
			{
?>
			<input type="hidden" value="<?php echo $id_p?>" name="id_pegawai">
		<input type="hidden" value="<?php echo $id_s;?>" id="status_hubungan" name="status_hubungan">
		<div class="form-group">
				<label for="nama" class="col-sm-4 control-label">Nama</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" required>
				</div>
			</div>
			<div class="form-group">
				<label for="tempat_lahir" class="col-sm-4 control-label">Tempat lahir</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Tempat Lahir" name="tempat_lahir" required>
				</div>
			</div>
			<div class="form-group">
				<label for="tgl_lahir" class="col-sm-4 control-label">Tanggal Lahir</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Tanggal Lahir" name="tgl_lahir" id="dp_tgl_lahir"required>
				</div>
			</div>
			<div class="form-group">
				<label for="jk" class="col-sm-4 control-label">Jenis Kelamin</label>
				<div class="col-sm-8">
				<select name="jk" class="form-control" placeholder="jenis Kelamin" required>
					<option>-Pilih Jenis kelamin-</option>
					<option value=1>Laki-laki</option>
					<option value=2>Perempuan</option>
				</select>
				</div>
			</div>
			<div class="form-group">
				<label for="keterangan" class="col-sm-4 control-label">Keterangan</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="keterangan">
				</div>
			</div>
			<?php
				if($tun == 2)
				{
			?>
			<div class="form-group" style="margin-left:10%">
				<label class="control-label">1. Fotokopi Akte Kelahiran Anak</label>
				<br/><br/>
				<input type="file" class="form-control" name="ufile_ak[]" <!--required--> >
			</div>
		<?php
				}
				else
					echo "";
					}
		}
		else
		{
?>
			<input type="hidden" value="<?php echo $id_p?>" name="id_pegawai">
		<input type="hidden" value="<?php echo $id_s;?>" id="status_hubungan" name="status_hubungan">
		<div class="form-group">
				<label for="nama" class="col-sm-4 control-label">Nama</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" required>
				</div>
			</div>
			<div class="form-group">
				<label for="tempat_lahir" class="col-sm-4 control-label">Tempat lahir</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Tempat Lahir" name="tempat_lahir" required>
				</div>
			</div>
			<div class="form-group">
				<label for="tgl_lahir" class="col-sm-4 control-label">Tanggal Lahir</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" placeholder="Tanggal Lahir" name="tgl_lahir" id="dp_tgl_lahir"required>
				</div>
			</div>
			<div class="form-group">
				<label for="jk" class="col-sm-4 control-label">Jenis Kelamin</label>
				<div class="col-sm-8">
				<select name="jk" class="form-control" placeholder="jenis Kelamin" required>
					<option>-Pilih Jenis kelamin-</option>
					<option value=1>Laki-laki</option>
					<option value=2>Perempuan</option>
				</select>
				</div>
			</div>
			<div class="form-group">
				<label for="keterangan" class="col-sm-4 control-label">Keterangan</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="keterangan">
				</div>
			</div>



<?php
		}
?>
			<br/>
<?php
	}
	else if($tun == '-')
	{

?>
	<div></div>
<?php
	}
?>
</form>

<script>
	$('#dp_tgl_lahir').datepicker({
	 autoclose: true,
	 format:"yyyy-mm-dd"
	});

	$('#dp_tgl_menikah').datepicker({
	 autoclose: true,
	 format:"yyyy-mm-dd"
	});

	$('#pilih_tunjangan').change(function(){
		$.ajax({
				type : "GET",
				url  : "perubahan_keluarga/berkas_penambahan_tunjangan.php",
				data : "hubungan=" + $('#stat_hub').val()+"& tunjangan="+$('#pilih_tunjangan').val(),
				success: function(data){
					$('#hasil').append(data);
					}
				});
	});
</script>
