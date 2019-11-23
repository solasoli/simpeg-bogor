<?php
	include_once "db.php";
	
	$q = mysql_query("SELECT id_pegawai, nama, nip_baru, tempat_lahir, tgl_lahir, pangkat_gol 
							FROM pegawai p
							ORDER BY nama");
	$result = '';
	$no = 1;	
	while($r = mysql_fetch_array($q)){
		$result[$no]["no"] = $no;
		$result[$no]["id_pegawai"] = $r["id_pegawai"];
		$result[$no]["nama"] = $r["nama"];
		$result[$no]["nip"] = $r["nip_baru"];
		$result[$no]["tempat_lahir"] = $r["tempat_lahir"];
		$result[$no]["tgl_lahir"] = $r["tgl_lahir"];
		$result[$no]["gol"] = $r["pangkat_gol"];
		$no++;
	}
?>