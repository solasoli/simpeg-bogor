<?php
	include('./class/keluarga_class.php');
	include('./library/format.php');
	$obj_keluarga =& new Keluarga_class;
	
	$idk = $_GET['id_kel'];
	$ids = $_GET['id_status'];
	$tun = $_GET['tun'];
	$od  = $_GET['od'];
	
	if($tun == -2 or $tun == -1)
		$ket 	= $_GET['ket'];
	else
		$ket = NULL;
	
	$keluarga 		= $obj_keluarga->get_anggota($idk);
?>
<div class="row">
<div class="col-md-8">
<div style="margin-left:5%">
<h3>Ubah Data</h3>
<hr/>
</div>

<form role="form" class="form-horizontal" action="pk_simpan_ubah_ajukan_ulang.php" method="post" enctype="multipart/form-data" name="keluarga_form" id="keluarga_form">
	<input type="hidden" name="id_status" id="id_status" value="<?php echo $keluarga->id_status;?>">
	<input type="hidden" name="id_keluarga" value="<?php echo $keluarga->id_keluarga;?>">
	<input type="hidden" name="id_pegawai"  value="<?php echo $keluarga->id_pegawai;?>">
	<input type="hidden" name="dapat_tunjangan" value=<?php echo $tun?>>
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
	<?php
		if($ids == 9)
		{
	?>
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
	<?php
		}
	?>
	<div class="form-group">
		<label for="pekerjaan" class="col-sm-4 control-label">Pekerjaan</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" value="<?php echo $keluarga->pekerjaan?>" name="pekerjaan">	
		</div>
	</div>
	<div class="form-group">
		<label for="jk" class="col-sm-4 control-label">Jenis Kelamin</label>
		<div class="col-sm-8">
		<?php $jk = $keluarga->jk;?>
		<select name="jk" class="form-control">
				<option value=1 <?php echo $jk == 1 ? "selected" : ""?> >Laki-laki</option>
				<option value=2 <?php echo $jk == 2 ? "selected" : ""?> >Perempuan</option>
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
		if($ids == 9 && $tun == 2)
		{
	?>
	<div class="form-group" style="margin-left:10%">
		<label class="control-label">1. Fotokopi Akte Menikah</label>
				<br/><br/>
		<input type="file" class="form-control" name="ufile_si[]">
	</div>
	<?php
		}
		if($ids ==10 && $tun == 2)
		{
	?>
	<div class="form-group" style="margin-left:10%">
		<label class="control-label">1. Fotokopi Akte Kelahiran Anak</label>
		<br/><br/>
		<input type="file" class="form-control" name="ufile_ak[]">
	</div>
	<?php
		}
		if($ket == 'meninggal')
		{
	?>
	<div class="form-group"  style="margin-left:10%" id="surat_kematian">
		<label class="control-label">1. Surat Kematian</label>
		<input type="file" class="form-control" name="ufile_mati[]">
	</div>
	<?php
		}
		if($ket == 'cerai')
		{
	?>
	<div class="form-group" id="surat_bekerja">
	<label class="col-sm-8 control-label">1. Surat Keterangan Cerai</label>
	<div class="col-sm-8">
		<input type="file" class="form-control" name='ufile_cerai[]'>
	</div>
</div>
	<?php
		}
		if($ket == 'bekerja')
		{
	?>
	<br/>
	<div class="form-group" id="surat_bekerja">
	<label class="col-sm-7 control-label">1. Surat Keterangan Telah Bekerja</label>
	<div class="col-sm-5">
		<input type="file" class="form-control" name="ufile_bekerja[]">
	</div>
</div>
	<?php
		}
	?>
<br/>
<div style="margin-left:10%">
	<button class="btn btn-sm btn-primary">Simpan</button> &nbsp;
	<a class="btn btn-sm btn-default" href="index3.php?x=modul/daftar_pengajuan.php&od=<?php echo $od?>">Kembali</a>
</div>
</form>
<br/>
<div>
</div>
	
<script>
	$('#dp_tgl_menikah').datepicker({
	 autoclose: true,
	 format:"yyyy-mm-dd"
	});
	
	$('#dp_tgl_lahir').datepicker({
	 autoclose: true,
	 format:"yyyy-mm-dd"
	});
</script>