<?php
//include('./konek.php');
include('./class/keluarga_class.php');
include('./library/format.php');

$obj_keluarga = new Keluarga_class;

$list_hubungan = $obj_keluarga->get_list_hubungan();

 if(isset($insert)== true)
	{
	?>
		<div class="alert alert-success" style="margin-left:10%;margin-right:30%;">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Data Berhasil Ditambah</strong>
			<a href="index3.php?x=modul/daftar_pengajuan.php&od=<?php echo $od?>" class="btn btn-primary">Lihat Daftar Pengajuan</a>
		</div>
		<br/><br/>
	<?php
	}
	?>
<div class="row">
	<div>
		<h4>Tambah Anggota keluarga</h4>
	</div>

</div>
<br/>
<div class="row">
<div class="col-md-8">
<form role="form" data-toggle="validator" class="form-horizontal" action="pk_simpan_tambah_keluarga.php?id_pegawai=<?php echo $od?>" method="POST" enctype="multipart/form-data" name="keluarga_form" id="keluarga_form">
	<div class="form-group">
		<label for="nama" class="col-sm-4 control-label">Hubungan</label>
		<div class="col-sm-8" id="status_hubungan">
			<select class="form-control" name="id_status" id="pilih_anggota" required>
				<option>-Pilih Status Hubungan-</option>
				<?php while($hub = mysqli_fetch_object($list_hubungan)) { ?>
					<option value="<?php echo $hub->id_status?>"><?php echo $hub->status_keluarga ?></option>
				<?php } ?>
			</select>
			<input type="hidden" name="id_pegawai" id="id_pegawai" value=<?php echo $od;?>>
		</div>
	</div>
	<div class="form-group" id="status_tunjangan">

	</div>
	<div id="hasil">

	</div>
	<br/>
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-info">Simpan</button>
			<a href="index3.php?x=box.php&od=<?php echo $od ?>" class="btn btn-danger">Kembali</a>
		</div>
</form>
</div>
</div>

<script>
	$(document).ready(function(){
		$('#pilih_anggota').change(function(){
			$('#hasil').html("");
			$.ajax({
				type 	:"GET",
				url  	: "perubahan_keluarga/status_tunjangan.php",
				data 	: "id_status="+$('#pilih_anggota').val(),
				success : function(data){
					$('#status_tunjangan').html(data);
				}
			});
		});

		$('#status_tunjangan').change(function(){
			$.ajax({
				type : "GET",
				url  : "perubahan_keluarga/tampil_status_hubungan.php",
				data : "id_status="+$('#pilih_anggota').val()+'&tunjangan='+$('#pilih_tunjangan').val()+'&id_pegawai='+$('#id_pegawai').val(),
				success: function(data){
					$('#hasil').html(data);

					var jumlah = $('#status').val();
					if(jumlah == 2)
					{
						alert("Tidak Bisa Melakukan Penambahan, Lakukan Pengurangan Jiwa Terlebih Dahulu");
						window.location = 'index3.php?x=modul/tambah_keluarga.php&od='+$('#id_pegawai').val();
					}
					else if(jumlah == 3)
					{
						alert("Tidak Bisa Melakukan Penambahan, Lakukan Pengurangan Jiwa Terlebih Dahulu");
						window.location = 'index3.php?x=modul/tambah_keluarga.php&od='+$('#id_pegawai').val();
					}
				}
			});
		});


	 });
</script>
