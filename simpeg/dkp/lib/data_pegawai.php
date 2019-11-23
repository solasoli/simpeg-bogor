<?php
	include_once "db.php";

	// nama, nip, tmt pangkat terakhir, golongan, tempat_lahir, tgl_lahir, pendidikan
	// jabatan, 

	$q = mysql_query("SELECT p.id_pegawai, p.nama, p.nip_baru, p.pangkat_gol, 
							  p.tempat_lahir, p.tgl_lahir
					 FROM pegawai p		
					 WHERE p.id_pegawai = '".$_REQUEST['id']."'"			
				);
			
	$r =  mysql_fetch_array($q);			
?>