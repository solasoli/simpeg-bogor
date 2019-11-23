<?php
	include('./class/keluarga_class.php');
	include('konek.php');
	
	$keluarga = new Keluarga_class;
	
	$id_status 		= $_POST['id_status'];
	$id_keluarga 	= $_POST['id_keluarga'];
	
	if($id_status == 10)
	{
		$nama_file_2 = $id_keluarga."_surat_keterangan_kuliah";
		
		$nama_file_2 .= get_file_type($_FILES['ufile_ak']['type'][0] );
		
		$_FILES['ufile_ak']['name'][0] = $nama_file_2;
		
		$path2 = "assets/berkas_perubahan_keluarga/penambahan/".$_FILES['ufile_ak']['name'][0];
			
		copy($_FILES['ufile_ak']['tmp_name'][0], $path2);
				
		$keluarga->update_berkas_keterangan_kuliah($id_keluarga, $path2);
		
		$od = $_GET['id_peg'];
		header('Location:index3.php?x=modul/daftar_pengajuan.php&od='.$od);
		
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