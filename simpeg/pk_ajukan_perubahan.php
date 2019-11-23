<?php
	include('/class/keluarga_class.php');
	include('/konek.php');

	$keluarga = new Keluarga_class;
	
	$tgl 	= $_GET['tgl'];
	$dt 	= $_GET['dt'];
	$od 	= $_GET['od'];
	
	//echo $od;
	$berkas 	= $keluarga->get_id_berkas_dasar($od);
	$row		= mysqli_fetch_array($berkas);
	$tgl_update = $row['tgl_update'];
	
	//untuk ajukan perubahan 
	if(mysqli_num_rows($berkas) == 0)
	{
		header("Location:index3.php?x=modul/upload_berkas_dasar_v.php&od=".$od);
	}
	
	if(strtotime($tgl_update) >= strtotime($tgl) )
	{
		$keluarga->ajukan_perubahan($tgl, $dt);
		header("Location:index3.php?x=modul/daftar_pengajuan.php&od=".$od);
	}
	else
	{
		header("Location:index3.php?x=modul/upload_berkas_dasar_v.php&od=".$od);
	}
	

?>