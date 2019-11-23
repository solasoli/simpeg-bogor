<?php
include "../konek.php";

$q = "SELECT id_pegawai FROM riwayat_mutasi_kerja r";

$rs = mysql_query($q);
while($r = mysql_fetch_array($rs)){
	$q = "SELECT id_riwayat, jabatan, id_j 
			FROM  `riwayat_mutasi_kerja` 
			WHERE  `id_pegawai` = $r[0]
				ORDER BY LENGTH(jabatan)";
		  
	$rsRiwayat = mysql_query($q);
	if(mysql_num_rows($rsRiwayat) > 1){
		
		$a = mysql_fetch_row($rsRiwayat);
		$b = mysql_fetch_row($rsRiwayat);
		print_r($a);		
		echo "<br/>";
		print_r($b);		
		echo "<br/>";
		if(
			($a[1] == 'Staf Pelaksana') ||
			($a[1] == 'Staff Pelaksana') ||
			($a[1] == '-') ||
			($a[1] == '')
		){
			$qUpdate = "UPDATE riwayat_mutasi_kerja SET 
							jabatan = '$b[1]',
							id_j = $b[2]
						WHERE id_riwayat = $a[0]";
			echo $qUpdate."<br/>";
			//mysql_query($qUpdate);
		}
			
		echo "<br/><br/>";
	}
}
?>