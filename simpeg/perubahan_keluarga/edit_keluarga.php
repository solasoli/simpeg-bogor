<?php
include('./class/keluarga_class.php');
include('./library/format.php');

$obj_keluarga =& new Keluarga_class;

$keluarga 		= $obj_keluarga->get_anggota($idk);


$format = new Format;

$tj = $keluarga->dapat_tunjangan;
// if(isset($_POST['id_keluarga']))
// {	
		
	// if($obj_keluarga->update_keluarga()){
		// $keluarga = $obj_keluarga->get_anggota($idk);
		// echo "<div class='alert alert-success' role='alert'>Update Berhasil</div></br>";		
	// }else{
		// echo "<div class='alert alert-danger' role='alert'>Sorry, Update Gagal</div></br>";
	// }		
// }

?>
<?php
	// $st = $obj_keluarga->get_anggota($idk);
	// $s 	= mysql_fetch_array($st);
	// echo $s['id_status'];
	
	$st = $keluarga->id_status;
	if($st == 9)
	{
?>
<!--Suami/Istri-->
<div class="row">
<div class="col-md-8">
<form role="form" class="form-horizontal" action="pk_update_keluarga.php" method="post" enctype="multipart/form-data" name="keluarga_form" id="keluarga_form">
	<input type="hidden" name="id_status" id="id_status" value="<?php echo $keluarga->id_status;?>">
	<input type="hidden" name="id_keluarga" value="<?php echo $keluarga->id_keluarga;?>">
	<input type="hidden" name="id_pegawai"  value="<?php echo $keluarga->id_pegawai;?>">
	<div class="form-group">
		<label for="nama" class="col-sm-4 control-label">Nama</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->nama?>" name="nama">
		</div>
	</div>
	<div class="form-group">
		<label for="tempat_lahir" class="col-sm-4 control-label">Tempat lahir</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->tempat_lahir ?>" name="tempat_lahir">
		</div>
	</div>
	<div class="form-group">
		<label for="tgl_lahir" class="col-sm-4 control-label">Tanggal Lahir</label>
		<div class="col-sm-8">
			<input id="dp_tgl_lahir" type="text" class="form-control" value="<?php echo $keluarga->tgl_lahir; //? $format->date_dmY($keluarga->tgl_lahir) : '' ?>" name="tgl_lahir">
		</div>
	</div>
	<div class="form-group">
		<label for="tgl_menikah" class="col-sm-4 control-label" >Tanggal Menikah</label>
		<div class="col-sm-8" >
			<input id="dp_tgl_menikah" type="text" class="form-control datepicker" value="<?php echo $keluarga->tgl_menikah //? $format->date_dmY($keluarga->tgl_menikah) : NULL ?>" name="tgl_menikah">
		</div>
	</div>
	<div class="form-group">
		<label for="tgl_menikah" class="col-sm-4 control-label" >Akte Menikah</label>
		<div class="col-sm-8" >
			<input type="text" class="form-control datepicker" value="<?php echo $keluarga->akte_menikah ?>" name="akte_menikah">
		</div>
	</div>
	<div class="form-group">
		<label for="pekerjaan" class="col-sm-4 control-label">Pekerjaan</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->pekerjaan?>" name="pekerjaan">	
		</div>
	</div>
	<div class="form-group">
		<label for="jk" class="col-sm-4 control-label">Jenis Kelamin</label>
		<div class="col-sm-8">
		<?php
			if($keluarga->jk == 1)
			{
		?>
		<select name="jk" class="form-control">
				<option value=1>Laki-laki</option>
				<option value=2>Perempuan</option>
		</select>	
			<?php
			}
			else if($keluarga->jk == 2)
			{
			?>
		<select name="jk" class="form-control">
				<option value=2>Perempuan</option>
				<option value=1>Laki-laki</option>
		</select>	
			<?php
				}
			?>
	
		</div>
	</div>
	<div class="form-group">
		<label for="keterangan" class="col-sm-4 control-label">Keterangan</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->keterangan?>" name="keterangan">
		</div>		
	</div>
	<?php
		if($tj == 0)
		{
	?>
	<div class="form-group">
		<label for="dapat_tunjangan" class="col-sm-4 control-label">Dapat Tunjangan</label>			
		<div class="col-sm-8">
		<select name="dapat_tunjangan"  id="dapat_tunjangan" class="form-control">
			<?php
				// if($keluarga->dapat_tunjangan == 1 || $keluarga->dapat_tunjangan == 0){
					// echo "<option value='".$keluarga->dapat_tunjangan."'>".($keluarga->dapat_tunjangan == 1 ? 'Dapat' : 'Tidak dapat' )."</option>";
				// }else{
					// echo "<option>Pilih</option>";
				// }					
			?>
			<option value=0>Tidak dapat tunjangan</option>
			<option value=2>Dapat tunjangan</option>
		</select>	
		</div>
	</div>
	<?php
		}
		else
		{
	?>
			<input type="hidden" name="dapat_tunjangan" value=<?php echo $keluarga->dapat_tunjangan?>> 
	<?php
		}
	?>
	<div id="hasil">
	
	</div>
<?php
	}
	else if($st == 10)
	{
?>
<div class="row">
<div class="col-md-8">
<form role="form" class="form-horizontal" action="pk_update_keluarga.php" method="post" enctype="multipart/form-data" name="keluarga_form" id="keluarga_form">
	<input type="hidden" name="id_status" id="id_status" value="<?php echo $keluarga->id_status;?>">
	<input type="hidden" name="id_keluarga"  value="<?php echo $keluarga->id_keluarga;?>">
	<input type="hidden" name="id_pegawai"  value="<?php echo $keluarga->id_pegawai;?>">
	<div class="form-group">
		<label for="nama" class="col-sm-4 control-label">Nama</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->nama?>" name="nama">
		</div>
	</div>
	<div class="form-group">
		<label for="tempat_lahir" class="col-sm-4 control-label">Tempat lahir</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->tempat_lahir ?>" name="tempat_lahir">
		</div>
	</div>
	<div class="form-group">
		<label for="tgl_lahir" class="col-sm-4 control-label">Tanggal Lahir</label>
		<div class="col-sm-8">
			<input id="dp_tgl_lahir" type="text" class="form-control" value="<?php echo $keluarga->tgl_lahir; //? $format->date_dmY($keluarga->tgl_lahir) : '' ?>" name="tgl_lahir">
		</div>
	</div>
	<div class="form-group">
		<label for="pekerjaan" class="col-sm-4 control-label">Pekerjaan</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->pekerjaan?>" name="pekerjaan">	
		</div>
	</div>
	<div class="form-group">
		<label for="jk" class="col-sm-4 control-label">Jenis Kelamin</label>
		<div class="col-sm-8">
		<select name="jk" class="form-control">
			<?php
			
				if($keluarga->jk == 1)
				{
			?>
				<option value=1>Laki-laki</option>
				<option value=2>Perempuan</option>
			<?php
				}
				else if($keluarga->jk ==2)
				{
			?>
				<option value=2>perempuan</option>
				<option value=1>Laki-laki</option>
			<?php
				}
			?>
		</select>	
		</div>
	</div>
	<div class="form-group">
		<label for="keterangan" class="col-sm-4 control-label">Keterangan</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->keterangan?>" name="keterangan">
		</div>		
	</div>
	<div>
	</div>
	<?php
		if($tj == 0)
		{
	?>
	<div class="form-group">
		<label for="dapat_tunjangan" class="col-sm-4 control-label">Dapat Tunjangan</label>			
		<div class="col-sm-8">
		<select name="dapat_tunjangan" id="dapat_tunjangan" class="form-control">
			<?php
				// if($keluarga->dapat_tunjangan == 1 || $keluarga->dapat_tunjangan == 0){
					// echo "<option value='".$keluarga->dapat_tunjangan."'>".($keluarga->dapat_tunjangan == 1 ? 'Dapat' : 'Tidak dapat' )."</option>";
				// }else{
					// echo "<option>Pilih</option>";
				// }					
			?>
			<option value=0>Tidak dapat tunjangan</option>
			<option value=2>Dapat tunjangan</option>
		</select>	
		</div>
	</div>
	<?php
		}
		else
		{
	?>
			<input type="hidden" name="dapat_tunjangan" value=<?php echo $keluarga->dapat_tunjangan?>> 
	<?php
		}
	?>
	<div id="hasil">
	</div>
	
<?php
	}
	else
	{
?>
<div class="row">
<div class="col-md-8">
<form role="form" class="form-horizontal" action="pk_update_keluarga.php" method="post" enctype="multipart/form-data" name="keluarga_form" id="keluarga_form">
	<input type="hidden" value="<?php echo $keluarga->id_status?>" name="id_status">
	<div class="form-group">
		<label for="nama" class="col-sm-4 control-label">Nama</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->nama?>" name="nama">
		</div>
	</div>
	<div class="form-group">
		<label for="tempat_lahir" class="col-sm-4 control-label">Tempat lahir</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->tempat_lahir ?>" name="tempat_lahir">
		</div>
	</div>
	<div class="form-group">
		<label for="tgl_lahir" class="col-sm-4 control-label">Tanggal Lahir</label>
		<div class="col-sm-8">
			<input id="dp_tgl_lahir" type="text" class="form-control" value="<?php echo $keluarga->tgl_lahir; //? $format->date_dmY($keluarga->tgl_lahir) : '' ?>" name="tgl_lahir">
		</div>
	</div>
	<div class="form-group">
		<label for="pekerjaan" class="col-sm-4 control-label">Pekerjaan</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->pekerjaan?>" name="pekerjaan">	
		</div>
	</div>
	<div class="form-group">
		<label for="jk" class="col-sm-4 control-label">Jenis Kelamin</label>
		<div class="col-sm-8">
		<select name="jk" class="form-control">
			<?php
			
				if($keluarga->jk == 1)
				{
			?>
				<option value=1>Laki-laki</option>
				<option value=2>Perempuan</option>
			<?php
				}
				else if($keluarga->jk ==2)
				{
			?>
				<option value=2>perempuan</option>
				<option value=1>Laki-laki</option>
			<?php
				}
			?>
		</select>	
		</div>
	</div>
	<div class="form-group">
		<label for="keterangan" class="col-sm-4 control-label">Keterangan</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->keterangan?>" name="keterangan">
		</div>		
	</div>
<?php
	}
?>
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<input type="hidden" name="id_keluarga" value="<?php echo $keluarga->id_keluarga ?>">
			<button type="submit" class="btn btn-info">Simpan</button>
			<a href="index3.php?x=box.php&od=<?php echo $od ?>&t=2" class="btn btn-danger">Kembali</a>
		</div>
	</div>
</form>
</div></div>
<script>
	$('#dp_tgl_lahir').datepicker({
	 autoclose: true,
	 format:"yyyy-mm-dd"
	});
	
	$('#dp_tgl_menikah').datepicker({
	 autoclose: true,
	 format:"yyyy-mm-dd"
	});
	
	$('#dapat_tunjangan').change(function(){
		$.ajax({
				type : "GET",
				url  : "modul/berkas_penambahan_tunjangan.php",
				data : "id_status="+ $('#id_status').val()+'&tunjangan='+$('#dapat_tunjangan').val(),
				success: function(data){
					$('#hasil').html(data);
				}
			});
	});
</script>

