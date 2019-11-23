<?php
	include('/class/keluarga_class.php');
	include('/konek.php');

	$keluarga = new Keluarga_class;
	
	$tgl 	= $_GET['tgl'];
	$id_peg = $_GET['od'];
	$tun 	= $_GET['tun'];
	
	$keluarga = $keluarga->ajukan_ulang($tgl, $tun);
	
	header('Location:index3.php?x=modul/daftar_pengajuan.php&od='.$id_peg);
	
	
?>