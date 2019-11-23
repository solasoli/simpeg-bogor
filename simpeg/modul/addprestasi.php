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


<div class="row">
<div class="col-md-8">
<form role="form" class="form-horizontal" action="prestasianak.php" method="POST" enctype="multipart/form-data" name="keluarga_form" id="keluarga_form">
	<input type="hidden" name="id_status" id="id_status" value="<?php echo $keluarga->id_status;?>">
	<input type="hidden" name="id_keluarga" value="<?php echo $keluarga->id_keluarga;?>">
	<input type="hidden" name="id_pegawai"  value="<?php echo $keluarga->id_pegawai;?>">
	<div class="form-group">
		<label for="nama" class="col-sm-4 control-label">Nama Anak</label>
		
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->nama?>" name="nama">
		</div>
	</div>
	<div class="form-group">
		<label for="tempat_lahir" class="col-sm-4 control-label">Prestasi</label><div class="col-sm-8">
		  <label>
		  <textarea name="prestasi" id="prestasi" cols="50" rows="3"></textarea>
		  </label>
		</div>
	</div>
	<div class="form-group">
		<label for="tgl_lahir" class="col-sm-4 control-label">Piagam / Sertifikat</label><div class="col-sm-8">
		  <label>
		  <input type="file" name="piagam" id="piagam" /> (Format pdf)
		  </label>
		</div>
        <br />
        &nbsp;&nbsp;<button type="submit" class="btn btn-success">Simpan</button>
	</div>
    
	
	
</form>
</div></div>
<script>
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
	
	$('#dp_tgl_menikah').datepicker({
	 autoclose: true,
	 format:"yyyy-mm-dd"
	});
	
	$('#dp_tgl_lahir').datepicker({
	 autoclose: true,
	 format:"yyyy-mm-dd"
	});
	
	});
	
</script>

