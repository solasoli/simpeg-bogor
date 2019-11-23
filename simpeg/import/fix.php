<?php

include "../konek.php";

$rs_fixing = mysql_query("SELECT f.nip
						FROM fixing f");

$i = 1;	
while($fixing = mysql_fetch_array($rs_fixing))
{
	
	$rs_pegawai = mysql_query("SELECT id_pegawai, nama 
							 FROM pegawai 
							 WHERE nip_baru LIKE '$fixing[nip]' OR nip_lama LIKE '$fixing[nip]'");
	
	if(mysql_num_rows($rs_pegawai) > 0)
	{
		
	}
	else
	{
		echo "$i    $fixing[nip] <br/>";
		$i++;
	}
	/*while($pegawai = mysql_fetch_array($rs_pegawai))
	{
		echo "$i - $fixing[nip] - $fixing[nama] <br/>";
		$i++;
	}*/
	
}

?>
