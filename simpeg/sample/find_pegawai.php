<?php
	include "../konek.php";
	$nama = $_POST["nama"];
	$rs = mysql_query("SELECT * FROM pegawai LIMIT 0,10");
	
    while($r = mysql_fetch_array($rs)) {
        $print_result = $print_result.
            $r["nama"]."|".$r["id_pegawai"].chr(10);
		
		echo "$print_result";
    }
?>