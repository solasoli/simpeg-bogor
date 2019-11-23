<?php

require "koncil.php";

$id_pegawai = $_POST['id_pegawai'];

$qry = "SELECT clk.id_unit_kerja FROM current_lokasi_kerja clk WHERE clk.id_pegawai = $id_pegawai ";
$rslt = mysqli_query($con,$qry);
$ata = mysqli_fetch_array($rslt);
$query1 = "update pegawai set kepsek_di = NULL where kepsek_di = ".$ata[0];
if(mysqli_query($con,$query1)){

	$query = " update pegawai 
				SET is_kepsek = IF(is_kepsek = 1, 0, 1), kepsek_di = ".$ata[0]."
				where id_pegawai = ".$id_pegawai;
				
	$result = mysqli_query($con,$query);
	
	if($result){
		echo "Berhasil update Kepala Sekolah";
	}else{
		echo "Gagal update Kepala Sekolah <br>".$query;
	}
}else{
	echo "gagal me-NULL kan kepsek ".$ata[0]; 
}

