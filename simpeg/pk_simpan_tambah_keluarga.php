<?php
include('class/keluarga_class.php');
include('konek.php');
include('library/format.php');

	$format = new Format;

	$keluarga 		=  new Keluarga_class;

	$id_pegawai		= $_GET['id_pegawai'];

	$id_status		= $_POST['id_status'];
	$nama			= $_POST['nama'];
	$tempat_lahir	= $_POST['tempat_lahir'];
	$tgl_lahir		= $_POST['tgl_lahir'];

	$jk				= $_POST['jk'];
	$keterangan		= $_POST['keterangan'];

	if($id_status == 9 || $id_status == 10)
		$dapat_tunjangan= $_POST['dapat_tunjangan'];


	//echo $jk;
	if($id_status == 9) // 9 = istri /suami
	{
		$tgl_menikah	= $_POST['tgl_menikah'];
		$akte_menikah	= $_POST['akte_menikah'];
		$no_karsus		= $_POST['no_karsus'];
		$pekerjaan		= $_POST['pekerjaan'];

		$insert_istri = $keluarga->insert_keluarga($id_pegawai,$id_status,mysqli_escape_string($mysqli, $nama),$tempat_lahir,$tgl_lahir,$tgl_menikah,
									$akte_menikah,$no_karsus,$pekerjaan,$jk,$dapat_tunjangan,$keterangan);

		if($insert){
			echo '<script type="text/javascript">
			window.location = "index3.php?x=box.php&od='.$id_pegawai.'&insert=true"
			</script>';
		}else{
			//echo 'gagal menyimpan keluarga '.;
			echo '<script type="text/javascript">
			window.location = "index3.php?x=box.php&od='.$id_pegawai.'"
			</script>';

		}
	}
	else if($id_status == 10) // 10 = anak
	{
		$tgl_menikah 	= NULL;
		$akte_menikah 	= NULL;
		$no_karsus		= NULL;
		$pekerjaan		= NULL;

		$insert = $keluarga->insert_anak($id_pegawai,$id_status,mysqli_escape_string($mysqli, $nama),$tempat_lahir,$tgl_lahir,
									$pekerjaan,$jk,$dapat_tunjangan,$keterangan);


		if($insert){
			echo '<script type="text/javascript">
			window.location = "index3.php?x=box.php&od='.$id_pegawai.'&insert=true"
			</script>';
		}else{
			echo '<script type="text/javascript">
			window.location = "index3.php?x=modul/tambah_keluarga.php&od='.$id_pegawai.'"
			</script>';
		}

	}
	else
	{
		$tgl_menikah 		=  NULL;
		$akte_menikah 		=  NULL;
		$no_karsus			=  NULL;
		// $pekerjaan			=  NULL;
		$dapat_tunjangan 	=  NULL;
		$keterangan			=  NULL;

		$keluarga->insert_keluarga($id_pegawai,$id_status,$nama,$tempat_lahir,$tgl_lahir,$tgl_menikah,
									$akte_menikah,$no_karsus,$pekerjaan,$jk,$dapat_tunjangan,$keterangan);

		echo '<script type="text/javascript">
			window.location = "index3.php?x=modul/tambah_keluarga.php&od='.$id_pegawai.'&insert=true"
			</script>';
	}

	function get_file_type($input)
		{
			switch($input)
			{
				case  "image/png" :
					  return ".png";
				case  "image/jpg" :
					  return ".jpg";
				case  "image/jpeg" :
					  return ".jpeg";
				case  "image/gif" :
					  return ".gif";
				case  "application/pdf" :
					  return ".pdf";
			}
		}
?>
