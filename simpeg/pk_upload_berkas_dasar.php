<?php
include('class/keluarga_class.php');
include('konek.php');
$keluarga = new Keluarga_class;


$id_p = $_POST['id_pegawai'];
			
$nama_file_0 = $id_p."_surat_pengatar_dari_unit_kerja";
$nama_file_1 = $id_p."_sk_pangkat_terakhir"; 
$nama_file_2 = $id_p."_skumptk";
$nama_file_3 = $id_p."_daftar_gaji";
				
$nama_file_0 .= get_file_type($_FILES['ufile']['type'][0] );
$nama_file_1 .= get_file_type($_FILES['ufile']['type'][1] );
$nama_file_2 .= get_file_type($_FILES['ufile']['type'][2] );
$nama_file_3 .= get_file_type($_FILES['ufile']['type'][3] );
				
$_FILES['ufile']['name'][0] = $nama_file_0;
$_FILES['ufile']['name'][1] = $nama_file_1;
$_FILES['ufile']['name'][2] = $nama_file_2;
$_FILES['ufile']['name'][3] = $nama_file_3;
				
$path0= "assets/berkas_perubahan_keluarga/berkas_dasar_pegawai/".$_FILES['ufile']['name'][0];
$path1= "assets/berkas_perubahan_keluarga/berkas_dasar_pegawai/".$_FILES['ufile']['name'][1];
$path2= "assets/berkas_perubahan_keluarga/berkas_dasar_pegawai/".$_FILES['ufile']['name'][2];
$path3= "assets/berkas_perubahan_keluarga/berkas_dasar_pegawai/".$_FILES['ufile']['name'][3];
		
//copy file to where you want to store file
copy($_FILES['ufile']['tmp_name'][0], $path0);
copy($_FILES['ufile']['tmp_name'][1], $path1);
copy($_FILES['ufile']['tmp_name'][2], $path2);
copy($_FILES['ufile']['tmp_name'][3], $path3);

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

$rs = $keluarga->get_berkas_dasar_pegawai($id_p);

	if(mysqli_num_rows($rs) > 0)
	{
		$keluarga->update_berkas_dasar_pegawai($id_p,$path0,$path1,$path2,$path3);
	}
	else
	{
		$keluarga->insert_berkas_dasar_pegawai($id_p,$path0,$path1,$path2,$path3);
	}
	
	//header('Location:index3.php?x=box.php&od='.$_GET['od']);
	header('Location:index3.php?x=modul/daftar_pengajuan.php&od='.$_GET['od']);

?>