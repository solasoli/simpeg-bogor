<?php
include('class/keluarga_class.php');
include('konek.php');
include('library/format.php');

$keluarga 		=  new Keluarga_class;
	
	$id_keluarga;
	$id_pegawai			= $_POST['id_pegawai'];
	$id_status;			
	$nama;
	$tempat_lahir;
	$tgl_lahir;
	$akte_kelahiran;
	$tgl_akte_kelahiran;
	$tgl_menikah;
	$akte_menikah;
	$tgl_akte_menikah;
	$tgl_meninggal;
	$akte_meninggal;
	$tgl_akte_meninggal;
	$tgl_cerai;
	$akte_cerai;
	$tgl_akte_cerai;
	$pekerjaan;
	$jk;
	$dapat_tunjangan;
	$keterangan;
	$status;
	$nik;
	$kuliah; //boolean 0 1
	$tgl_lulus;
	$no_ijazah;
	$nama_sekolah;
	
	
	/*
	$tanggal_menikah	= NULL;
	$akte_menikah		= NULL;
	$dt 				= NULL;
	$path0				= NULL;
	$path1				= NULL; 
	$path2				= NULL; 
	$path3				= NULL; 
	$path4				= NULL; 
	$path5				= NULL;
	
	
	$dt 				= $_POST['dapat_tunjangan'];
	
	$id_k 				= $_POST['id_keluarga'];
	$nama 				= $_POST['nama'];
	$tempat_lahir 		= $_POST['tempat_lahir'];
	$tanggal_lahir		= $_POST['tgl_lahir'];
	$pekerjaan 			= $_POST['pekerjaan'];
	$jk 				= $_POST['jk'];
	$ket				= $_POST['keterangan'];
	$id_status 			= $_POST['id_status'];
	
	echo "<pre>";
	var_dump($_POST);
	echo "</pre>";
	exit;
	*/
	
	if( $id_status == 9)
	{
		$tanggal_menikah	= $_POST['tgl_menikah'];
		$akte_menikah		= $_POST['akte_menikah'];
		
		
	}
	else if( $id_status == 10 )
	{
		$nama_file_1 = $id_k."_surat_kelahiran_anak";
						
		$nama_file_1 .= get_file_type($_FILES['ufile_ak']['type'][0] );
		
		//$_FILES['ufile_ak']['name'][0] = $nama_file_1;
		
		//$path1= "assets/berkas_perubahan_keluarga/penambahan/".$_FILES['ufile_ak']['name'][0];
		
		//copy($_FILES['ufile_ak']['tmp_name'][0], $path1);
		
		//$keluarga->insert_berkas_perubahan_keluarga($id_k, $path0, $path1, $path2, $path3, $path4, $path5);
	}
	
	//$keluarga->update_keluarga($id_k,mysql_escape_string($nama),$tempat_lahir,$nik,$tanggal_lahir,$jk,$dt,$ket,$tanggal_menikah,$akte_menikah,$pekerjaan);
	$keluarga->update_keluarga();
	
	header("Location:index3.php?x=box.php&od=".$_POST['id_pegawai']);
	//header("Location:index3.php?x=modul/edit_keluarga.php&od=".$id_peg."&idk=".$idk);
	
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
