<?php
	require_once("../../konek.php");
	
	extract($_POST);
	
	$q = "SELECT * FROM unit_kerja WHERE nama_baru LIKE '%$keywords%'";
	$result = mysql_query($q);
	
	if(mysql_num_rows($result) > 0)
		$r = mysql_fetch_array($result);
		
	echo $r['nama_baru'];
?>