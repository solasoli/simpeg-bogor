<?php
include('./class/keluarga_class.php');
include('./library/format.php');
$obj_keluarga = new Keluarga_class;

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
<form role="form" class="form-horizontal" action="pk_update_keluarga.php" method="POST" enctype="multipart/form-data" name="keluarga_form" id="keluarga_form">
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
			<input id="dp_tgl_lahir" type="text" class="form-control tanggalan" value="<?php echo $keluarga->tgl_lahir; //? $format->date_dmY($keluarga->tgl_lahir) : '' ?>" name="tgl_lahir">
		</div>
	</div>
	<div class="form-group">
		<label for="tempat_lahir" class="col-sm-4 control-label">NIK</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->nik ?>" name="nik">
		</div>
	</div>
	<div class="form-group">
		<label for="tgl_menikah" class="col-sm-4 control-label" >Tanggal Menikah</label>
		<div class="col-sm-8" >
			<input id="tgl_menikah" name="tgl_menikah" type="text" class="form-control tanggalan" value="<?php echo $keluarga->tgl_menikah //? $format->date_dmY($keluarga->tgl_menikah) : NULL ?>" name="tgl_menikah">
		</div>
	</div>
	<div class="form-group">
		<label for="akte_menikah" class="col-sm-4 control-label" >Akte Menikah</label>
		<div class="col-sm-8" >
			<input type="text" class="form-control" value="<?php echo $keluarga->akte_menikah ?>" name="akte_menikah">
		</div>
	</div>
	
	<div class="form-group">
		<label for="pekerjaan" class="col-sm-4 control-label">Pekerjaan</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->pekerjaan?>" name="pekerjaan">	
		</div>
	</div>
	<div class="form-group">
		<label for="jk" class="col-sm-4 control-label">Status</label>
		<div class="col-sm-8">
		
		<select name="status_kawin" id="status_kawin" class="form-control">
				<option value="Menikah" <?php if($keluarga->status == NULL || $keluarga->status == 'Menikah') echo " selected";  ?>>Menikah</option>
				<option value="Cerai" <?php if($keluarga->status == "Cerai") echo " selected";  ?>>Cerai</option>
				<option value="Meninggal" <?php if($keluarga->status == "Meninggal") echo " selected";  ?>>Meninggal</option>
		</select>
		</div>
	</div>
	<div id="cerai" class="<?php echo $keluarga->status == 'Cerai' ? '' : 'hide'?>">
		<div class="form-group">
			<label for="tgl_cerai" class="col-sm-4 control-label" >Tanggal Cerai</label>
			<div class="col-sm-8" >
				<input id="tgl_cerai" type="text" class="form-control tanggalan" value="<?php echo $keluarga->tgl_cerai //? $format->date_dmY($keluarga->tgl_menikah) : NULL ?>" name="tgl_cerai">
			</div>
		</div>
		<div class="form-group">
			<label for="akte_cerai" class="col-sm-4 control-label" >Akte Cerai</label>
			<div class="col-sm-8" >
				<input type="text" class="form-control" value="<?php echo $keluarga->akte_cerai?>" name="akte_cerai">	
			</div>
		</div>
		<div class="form-group">
			<label for="tgl_menikah" class="col-sm-4 control-label" >Tanggal Akte Cerai</label>
			<div class="col-sm-8" >
				<input id="tgl_akte_cerai" type="text" class="form-control tanggalan" value="<?php echo $keluarga->tgl_akte_cerai //? $format->date_dmY($keluarga->tgl_menikah) : NULL ?>" name="tgl_akte_cerai">
			</div>
		</div>
	</div>
	<div id="meninggal" class="<?php echo $keluarga->status == 'Meninggal' ? '' : 'hide'?>">
		<div class="form-group">
			<label for="tgl_meninggal" class="col-sm-4 control-label" >Tanggal Meninggal</label>
			<div class="col-sm-8" >
				<input id="tgl_meninggal" type="text" class="form-control tanggalan" value="<?php echo $keluarga->tgl_meninggal //? $format->date_dmY($keluarga->tgl_menikah) : NULL ?>" name="tgl_meninggal">
			</div>
		</div>
		<div class="form-group">
			<label for="akte_meninggal" class="col-sm-4 control-label" >Akte Meninggal</label>
			<div class="col-sm-8" >
				<input type="text" class="form-control datepicker" value="<?php echo $keluarga->akte_meninggal ?>" name="akte_meninggal">
			</div>
		</div>
		<div class="form-group">
			<label for="tgl_akte_meninggal" class="col-sm-4 control-label" >Tanggal Akte Meninggal</label>
			<div class="col-sm-8" >
				<input id="tgl_akte_meninggal" type="text" class="form-control tanggalan" value="<?php echo $keluarga->tgl_akte_meninggal //? $format->date_dmY($keluarga->tgl_menikah) : NULL ?>" name="tgl_akte_meninggal">
			</div>
		</div>
	</div>
	<div class="form-group">
		<label for="keterangan" class="col-sm-4 control-label">Keterangan</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->keterangan ?>" name="keterangan">
		</div>		
	</div>
	
	<div class="form-group">
		<label for="dapat_tunjangan" class="col-sm-4 control-label">Dapat Tunjangan</label>			
		<div class="col-sm-8">
		<select name="dapat_tunjangan"  id="dapat_tunjangan" class="form-control">
			<?php
				 if($keluarga->dapat_tunjangan == 1 || $keluarga->dapat_tunjangan == 0){
					 echo "<option value='".$keluarga->dapat_tunjangan."'>".($keluarga->dapat_tunjangan == 1 ? 'Dapat' : 'Tidak dapat' )."</option>";
				 }else{
					 echo "<option>Pilih</option>";
				 }					
			?>
			<option value=0>Tidak dapat tunjangan</option>
			<option value=1>Dapat tunjangan</option>
		</select>	
		</div>
	</div>
	
	<div id="hasil">
	
	</div>
<?php
	}
	else if($st == 10) //anak
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
		<label for="tempat_lahir" class="col-sm-4 control-label">NIK</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->nik ?>" name="nik">
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
	<?php 
		
		$tgl_lahir = new DateTime($keluarga->tgl_lahir);
		$hari_ini = new DateTime(DATE('Y-m-d'));  
		
		$usia_anak = $hari_ini->diff($tgl_lahir);
		 if($usia_anak->y >= 21 ){ 
	?>
	<div class="form-group">
		<label for="kuliah" class="col-sm-4 control-label">Kuliah</label>
		<div class="col-sm-8">
		<select name="kuliah" id="kuliah" class="form-control" >
			
				<option value=0 <?php if($keluarga->kuliah == 0 ) echo (" selected"); ?>>Tidak Kuliah</option>
				<option value=1 <?php if($keluarga->kuliah == 1) echo (" selected"); ?>>Kuliah</option>
		
		</select>	
		</div>
	</div>
	<div class="form-group kuliah <?php echo $keluarga->kuliah == 1 ? "" : "hide" ?>">
		<label for="nama_sekolah" class="col-sm-4 control-label">Nama Perguruan Tinggi</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->nama_sekolah?>" name="nama_sekolah">	
		</div>
	</div>	
	<div class="form-group kuliah <?php echo $keluarga->kuliah == 1 ? "" : "hide" ?>">
		<label for="tgl_lulus" class="col-sm-4 control-label">Tanggal_lulus</label>
		<div class="col-sm-8">
			<input id="tgl_lulus" name="tgl_lulus" type="text" class="form-control" value="<?php echo $keluarga->tgl_lulus; //? $format->date_dmY($keluarga->tgl_lahir) : '' ?>" name="tgl_lulus">
			<span id="helpBlock2" class="help-block">di isi jika telah lulus kuliah.</span>
		</div>
		
	</div>
	<div class="form-group kuliah <?php echo $keluarga->kuliah == 1 ? "" : "hide" ?>">
		<label for="nama_sekolah" class="col-sm-4 control-label">No Ijazah</label>
		<div class="col-sm-8">
			<input type="text" name="no_ijazah" class="form-control" value="<?php echo $keluarga->no_ijazah?>" name="no_ijazah">	
			<span id="helpBlock2" class="help-block">di isi jika telah lulus kuliah.</span>
		</div>
	</div>
	<?php } ?>
	
	<div class="form-group">
		<label for="jk" class="col-sm-4 control-label">Jenis Kelamin</label>
		<div class="col-sm-8">
		<select name="jk" class="form-control">
			
				<option value=1 <?php if($keluarga->jk == 1) echo (" selected"); ?>>Laki-laki</option>
				<option value=2 <?php if($keluarga->jk == 2) echo (" selected"); ?>>Perempuan</option>
		
		</select>	
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-8 col-md-offset-4">	
		<label class="checkbox-inline">
		  <input type="checkbox" <?php echo $keluarga->status == 'Meninggal' ? 'Checked' : '' ?> id="status_meninggal_anak" name="status_meninggal_anak" onclick="statusMeninggal()" value="Meninggal"> Meninggal Dunia
		</label>
		</div>
	</div -->
	<div id="meninggal" class="<?php echo $keluarga->status == 'Meninggal' ? '' : 'hide'?>">
		<div class="form-group">
			<label for="tgl_meninggal" class="col-sm-4 control-label" >Tanggal Meninggal</label>
			<div class="col-sm-8" >
				<input id="tgl_meninggal" type="text" class="form-control tanggalan" value="<?php echo $keluarga->tgl_meninggal //? $format->date_dmY($keluarga->tgl_menikah) : NULL ?>" name="tgl_meninggal">
			</div>
		</div>
		<div class="form-group">
			<label for="akte_meninggal" class="col-sm-4 control-label" >Akte Meninggal</label>
			<div class="col-sm-8" >
				<input type="text" class="form-control datepicker" value="<?php echo $keluarga->akte_meninggal ?>" name="akte_meninggal">
			</div>
		</div>
		<div class="form-group">
			<label for="tgl_akte_meninggal" class="col-sm-4 control-label" >Tanggal Akte Meninggal</label>
			<div class="col-sm-8" >
				<input id="tgl_akte_meninggal" type="text" class="form-control tanggalan" value="<?php echo $keluarga->tgl_akte_meninggal //? $format->date_dmY($keluarga->tgl_menikah) : NULL ?>" name="tgl_akte_meninggal">
			</div>
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
	<div class="form-group">
		<label for="dapat_tunjangan" class="col-sm-4 control-label">Dapat Tunjangan</label>			
		<div class="col-sm-8">
		<select name="dapat_tunjangan" id="dapat_tunjangan" class="form-control">
			<?php
				if($keluarga->dapat_tunjangan == 1 || $keluarga->dapat_tunjangan == 0){
					 echo "<option value='".$keluarga->dapat_tunjangan."'>".($keluarga->dapat_tunjangan == 1 ? 'Dapat' : 'Tidak dapat' )."</option>";
				 }else{
					 echo "<option>Pilih</option>";
				 }					
			?>
			<option value=0>Tidak dapat tunjangan</option>
			<option value=1>Dapat tunjangan</option>
		</select>	
		</div>
	</div>
	
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
		<label for="tempat_lahir" class="col-sm-4 control-label">NIK</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->nik ?>" name="nik">
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
			<button type="butto" class="btn btn-info">Simpan</button>
			<!--a class="btn btn-info" onclick="update_suami()">SIMPAN</a-->
			<a href="index3.php?x=box.php&od=<?php echo $od ?>&t=2" class="btn btn-danger">Kembali</a>
		</div>
	</div>
</form>
</div></div>
<script>

	function statusMeninggal(){
		//stat = $("#status_meninggal_anak").val();
		//alert(stat);
		if(	$('#status_meninggal_anak').is(':checked')){
			$("#meninggal").removeClass("hide");
		}else{
			$("#meninggal").addClass("hide");
		}
	}
	$(document).ready(function(){
	$('#_dapat_tunjangan').change(function(){
		$.ajax({
				type : "GET",
				url  : "modul/berkas_penambahan_tunjangan.php",
				data : "id_status="+ $('#id_status').val()+'&tunjangan='+$('#dapat_tunjangan').val(),
				success: function(data){
					$('#hasil').html(data);
				}
			});
	});
	
	$('#status_kawin').change(function(){
		//alert("test");
		nilai = $("#status_kawin").val();
		if(nilai == 'Cerai'){
			$("#cerai").removeClass("hide");
			$("#meninggal").addClass("hide");
		}else if(nilai == 'Meninggal'){
			$("#meninggal").removeClass("hide");
			$("#cerai").addClass("hide");
		}else{
			$("#cerai").addClass("hide");
			$("#meninggal").addClass("hide");
		}
		
	
		
	});
	$('#kuliah').change(function(){
		if($('#kuliah').val() == '1'){
			//alert("test");
			$('.kuliah').removeClass("hide");
		}else{
			$('.kuliah').addClass("hide");
		}
	});
	
	$('.tanggalan').datepicker({
	 autoclose: true,
	 format:"yyyy-mm-dd"
	});
	
	$('#tgl_menikah').datepicker({
	 autoclose: true,
	 format:"yyyy-mm-dd"
	});
	
	$('#dp_tgl_lahir').datepicker({
	 autoclose: true,
	 format:"yyyy-mm-dd"
	});
	
	$('#tgl_lulus').datepicker({
	 autoclose: true,
	 format:"yyyy-mm-dd"
	});
	
	});
	
</script>

