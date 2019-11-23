<?php
include('class/keluarga_class.php');
include('konek.php');
include('library/format.php');

	$keluarga 		= & new Keluarga_class;
	
	$id_peg 			= $_POST['id_pegawai'];
	$tanggal_menikah	= NULL;
	$akte_menikah		= NULL;
	$dt 				= NULL;
	$path0				= NULL;
	$path1				= NULL; 
	$path2				= NULL; 
	$path3				= NULL; 
	$path4				= NULL; 
	$path5				= NULL;
	
	$id_k 				= $_POST['id_keluarga'];
	$nama 				= $_POST['nama'];
	$tempat_lahir 		= $_POST['tempat_lahir'];
	$tanggal_lahir		= $_POST['tgl_lahir'];
	$pekerjaan 			= $_POST['pekerjaan'];
	$jk 				= $_POST['jk'];
	$ket				= $_POST['keterangan'];
	$id_status 			= $_POST['id_status'];
	$dt 				= $_POST['dapat_tunjangan'];
	$idp				= $_POST['id_pegawai'];
	
	 if($id_status == 9)
	 {
		$tanggal_menikah	= $_POST['tgl_menikah'];
		$akte_menikah		= $_POST['akte_menikah'];
	 }
		
	if( $id_status == 9 && $dt == 2)
	{
		$nama_file_0 = $id_k."_surat_menikah";
		
		$nama_file_0 .= get_file_type($_FILES['ufile_si']['type'][0] );
		
						
		$_FILES['ufile_si']['name'][0] = $nama_file_0;
		
		
		if($_FILES['ufile_si']['tmp_name'][0]	!= NULL)
		{
			$path0= "assets/berkas_perubahan_keluarga/penambahan/".$_FILES['ufile_si']['name'][0];
			
			copy($_FILES['ufile_si']['tmp_name'][0], $path0);
		}
	}
	else if( $id_status == 10 && $dt == 2)
	{
		$nama_file_1 = $id_k."_surat_kelahiran_anak";
						
		$nama_file_1 .= get_file_type($_FILES['ufile_ak']['type'][0] );
		
		$_FILES['ufile_ak']['name'][0] = $nama_file_1;
		
		if($_FILES['ufile_ak']['tmp_name'][0]	!= NULL)
		{
			$path1= "assets/berkas_perubahan_keluarga/penambahan/".$_FILES['ufile_ak']['name'][0];
		
			copy($_FILES['ufile_ak']['tmp_name'][0], $path1);
		}
	}
	
	if($ket == 'meninggal')
	{
		$nama_file_1 = $id_k."_surat_meninggal";
						
		$nama_file_1 .= get_file_type($_FILES['ufile_mati']['type'][0] );
		
		$_FILES['ufile_mati']['name'][0] = $nama_file_1;
		
		if($_FILES['ufile_mati']['tmp_name'][0]	!= NULL)
		{
			$path1= "assets/berkas_perubahan_keluarga/pengurangan/".$_FILES['ufile_mati']['name'][0];
		
			copy($_FILES['ufile_mati']['tmp_name'][0], $path1);
		}
	}
	
	if($ket == 'cerai')
	{
		$nama_file_1 = $id_k."_surat_cerai";
						
		$nama_file_1 .= get_file_type($_FILES['ufile_cerai']['type'][0] );
		
		$_FILES['ufile_cerai']['name'][0] = $nama_file_1;
		
		if($_FILES['ufile_cerai']['tmp_name'][0]	!= NULL)
		{
			$path1= "assets/berkas_perubahan_keluarga/pengurangan/".$_FILES['ufile_cerai']['name'][0];
		
			copy($_FILES['ufile_cerai']['tmp_name'][0], $path1);
		}
	}
	
	if($ket == 'bekerja')
	{
		$nama_file_1 = $id_k."_surat_telah_bekerja";
						
		$nama_file_1 .= get_file_type($_FILES['ufile_bekerja']['type'][0] );
		
		$_FILES['ufile_bekerja']['name'][0] = $nama_file_1;
		
		if($_FILES['ufile_bekerja']['tmp_name'][0]	!= NULL)
		{
			$path1= "assets/berkas_perubahan_keluarga/pengurangan/".$_FILES['ufile_bekerja']['name'][0];
		
			copy($_FILES['ufile_bekerja']['tmp_name'][0], $path1);
		}
	}
	
	$keluarga->update_keluarga($id_k,$nama,$tempat_lahir,$tanggal_lahir,$jk,$dt,$ket,$tanggal_menikah,$akte_menikah);
	
	header("Location:index3.php?x=modul/daftar_pengajuan.php&od=".$idp);

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