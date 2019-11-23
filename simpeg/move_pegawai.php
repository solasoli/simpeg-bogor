<?php
include "konek.php";

extract($_POST);

$qRmk = "SELECT r.id_riwayat
		 FROM riwayat_mutasi_kerja r 		 
		 INNER JOIN sk s ON r.id_sk = s.id_sk
		 INNER JOIN
		 (
		 	SELECT r.id_pegawai, MAX(tmt) as max_tmt 
		 	FROM riwayat_mutasi_kerja r 
		 	INNER JOIN sk s ON r.id_sk = s.id_sk
		 	WHERE r.id_pegawai = $id_pegawai
		 ) AS t ON t.id_pegawai = r.id_pegawai AND s.tmt = t.max_tmt";
	//echo $qRmk;	 
$rsRmk = mysqli_query($mysqli,$qRmk);
$rmk = mysqli_fetch_array($rsRmk);


$qUpdate = "UPDATE riwayat_mutasi_kerja SET id_j_bos = $id_j WHERE id_riwayat = $rmk[0]";
if(mysqli_query($mysqli,$qUpdate))
{
	echo "1";
}
else {
	echo "0";
}
?>