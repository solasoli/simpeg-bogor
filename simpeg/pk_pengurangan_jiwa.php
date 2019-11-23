<?php
include('class/keluarga_class.php');
include('konek.php');
include('library/format.php');

$keluarga 	=& new Keluarga_class;

$id_pegawai			= $_POST['id_pegawai'];
$id_status			= $_POST['id_status'];
$id_keluarga		= $_POST['id_keluarga'];
$status_tunjangan 	= $_POST['status_tunjangan'];
$keterangan 		= $_POST['keterangan'];

$cek = $keluarga->get_berkas_perubahan_keluarga($id_keluarga);

if($id_status == 9)
{
	if($keterangan == "meninggal")
	{
		$tanggal_meninggal	= $_POST['tanggal_meninggal'];
		$akte_meninggal		= $_POST['akte_meninggal'];
		$tanggal_cerai		= NULL;
		$akte_cerai			= NULL;
		
		$nama_file_0 = $id_keluarga."_surat_meninggal";
		
		$nama_file_0 .= get_file_type($_FILES['ufile_mati']['type'][0] );
		
						
		$_FILES['ufile_mati']['name'][0] = $nama_file_0;
		
		$path4 = "assets/berkas_perubahan_keluarga/pengurangan/".$_FILES['ufile_mati']['name'][0];
			
		copy($_FILES['ufile_mati']['tmp_name'][0], $path4);
		
		if(mysqli_num_rows($cek) > 0)
			$keluarga->update_berkas_kematian($id_keluarga, $path4);
		else
			$keluarga->insert_berkas_perubahan_keluarga($id_keluarga, $p0=NULL, $p1=NULL, $p2=NULL, $p3=NULL, $path4, $p5=NULL);
		
		
	}
	else if($keterangan == "cerai")
	{
		$tanggal_cerai		= $_POST['tanggal_cerai'];
		$akte_cerai			= $_POST['akte_cerai'];
		
		$tanggal_meninggal	= NULL;
		$akte_meninggal		= NULL;
		
		$nama_file_0 = $id_keluarga."_surat_cerai";
		
		$nama_file_0 .= get_file_type($_FILES['ufile_cerai']['type'][0] );
		
						
		$_FILES['ufile_cerai']['name'][0] = $nama_file_0;
		
		$path5= "assets/berkas_perubahan_keluarga/pengurangan/".$_FILES['ufile_cerai']['name'][0];
			
		copy($_FILES['ufile_cerai']['tmp_name'][0], $path5);
		
		//update
		if(mysqli_num_rows($cek) > 0)
			$keluarga->update_berkas_cerai($id_keluarga, $path5);
		else
			$keluarga->insert_berkas_perubahan_keluarga($id_keluarga, $p0=NULL, $p1=NULL, $p2=NULL, $p3=NULL, $path4, $p5=NULL);
	}
	
	$keluarga->update_pengurangan_jiwa($status_tunjangan,$id_keluarga,$keterangan,$tanggal_meninggal,$akte_meninggal,$tanggal_cerai,$akte_cerai);

	header('Location:index3.php?x=modul/daftar_pengajuan.php&od='.$id_pegawai);
}
else if($id_status == 10)
{
	if($keterangan == "meninggal")
	{
		$tanggal_meninggal	= $_POST['tanggal_meninggal'];
		$akte_meninggal		= $_POST['akte_meninggal'];
		$tanggal_cerai		= NULL;
		$akte_cerai			= NULL;
		
		$nama_file_0 = $id_keluarga."_surat_meninggal";
		
		$nama_file_0 .= get_file_type($_FILES['ufile_mati']['type'][0] );
		
						
		$_FILES['ufile_mati']['name'][0] = $nama_file_0;
		
		$path4 = "assets/berkas_perubahan_keluarga/pengurangan/".$_FILES['ufile_mati']['name'][0];
			
		copy($_FILES['ufile_mati']['tmp_name'][0], $path4);
		
		//update berkas
		if(mysqli_num_rows($cek) > 0)
			$keluarga->update_berkas_kematian($id_keluarga, $path4);
		else
			$keluarga->insert_berkas_perubahan_keluarga($id_keluarga, $p0=NULL, $p1=NULL, $p2=NULL, $p3=NULL, $path4, $p5=NULL);
	}
	else if($keterangan == "bekerja")
	{
		$tanggal_meninggal	= NULL;
		$akte_meninggal		= NULL;
		$tanggal_cerai		= NULL;
		$akte_cerai			= NULL;
		
		$nama_file_0 = $id_keluarga."_surat_telah_bekerja";
		
		$nama_file_0 .= get_file_type($_FILES['ufile_bekerja']['type'][0] );
		
						
		$_FILES['ufile_bekerja']['name'][0] = $nama_file_0;
		
		$path3 = "assets/berkas_perubahan_keluarga/pengurangan/".$_FILES['ufile_bekerja']['name'][0];
			
		copy($_FILES['ufile_bekerja']['tmp_name'][0], $path3);
		
		//update berkas
		if(mysqli_num_rows($cek) > 0)
			$keluarga->update_berkas_telah_bekerja($id_keluarga, $path3);
		else
			$keluarga->insert_berkas_perubahan_keluarga($id_keluarga, $p0=NULL, $p1=NULL, $p2=NULL, $path3, $p4=NULL, $p5=NULL);
	}
	
	$keluarga->update_pengurangan_jiwa($status_tunjangan,$id_keluarga,$keterangan,$tanggal_meninggal,$akte_meninggal,$tanggal_cerai,$akte_cerai);
	
	
	header('Location:index3.php?x=modul/daftar_pengajuan.php&od='.$id_pegawai);
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