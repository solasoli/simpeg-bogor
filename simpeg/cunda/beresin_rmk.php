<?php
/*
 * File ini digunakan untuk memperbaiki kesalahan jenjab di tabel pegawai dan tabel RMK.
 * Kesalahan yang terjadi adalah ketika batch unpdate lokasi kerja ke SKPD baru, jenjab pegawai yang awalnya
 * fungsional malah menjadi struktural.
 */

include "../konek.php";

$qAll = "SELECT id_pegawai, jenjab
FROM  `riwayat_mutasi_kerja` 
WHERE jenjab NOT LIKE  '%struktural%'
GROUP BY id_pegawai
ORDER BY  `riwayat_mutasi_kerja`.`jenjab` DESC";

$rsAll = mysql_query($qAll);

while($rAll = mysql_fetch_array($rsAll))
{
	$qSK = "SELECT jenjab 
		    FROM riwayat_mutasi_kerja
		    WHERE id_pegawai = $rAll[id_pegawai]";
	
	$rsSK = mysql_query($qSK);
	
	if(mysql_num_rows($rsSK) > 1)
	{
		echo $rAll['jenjab']."<br/>";
	}
}

?>