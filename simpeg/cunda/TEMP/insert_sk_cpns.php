Untuk memasukkan SK CPNS (default) ke dalam tabel sk bagi pegawai yang belum pernah mengumpulkan SK apapun.
<?php

require_once("../../konek.php");

$q = mysql_query("SELECT pegawai.id_pegawai
					FROM pegawai
					LEFT JOIN sk ON pegawai.id_pegawai = sk.id_pegawai
					WHERE sk.id_pegawai IS NULL AND pegawai.flag_pensiun = 0;");
					
echo mysql_num_rows($q)."<br/>";					
while($r = mysql_fetch_array($q))
{
	$q2 = mysql_query("INSERT INTO sk()");
	echo $q2;
	echo "ID Pegawai ".$r[0]." have new SK.<br/>";
}

?>