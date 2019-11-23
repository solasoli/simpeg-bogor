<?php
	$local = mysqli_connect("simpeg.db.kotabogor.net", "simpeg", "Madangkara2017");
	mysqli_select_db("simpeg", $local);
	
	$remote = mysqli_connect("simpeg.org","k0230277_simpeg","51mp3612"); 
	mysqli_select_db("k0230277_simpeg", $remote);
	
	$rs = mysqli_query($mysqli,"SELECT * FROM current_lokasi_kerja", $local);
	
	if($rs != '')
	{
		mysqli_query($mysqli,"DELETE FROM current_lokasi_kerja", $remote);
		while($r = mysqli_fetch_array($rs)){
			$q = "INSERT INTO current_lokasi_kerja(id_aja, id_pegawai, id_unit_kerja) VALUES('".$r[id_aja]."', '".$r[id_pegawai]."', '".$r[id_unit_kerja]."')";
			mysqli_query($mysqli,$q, $remote);
		}
	}
?>