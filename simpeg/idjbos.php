<?php

include("konek.php");

$q=mysqli_query($mysqli,"SELECT kegiatan_member from knj_kegiatan group by kegiatan_member");

while($data=mysqli_fetch_array($q))
{
	$qbos=mysqli_query($mysqli,"select id_j_bos from riwayat_mutasi_kerja rmk inner join sk on sk.id_sk=rmk.id_sk where rmk.id_pegawai=$data[0] order by tmt desc");

	$bos=mysqli_fetch_array($qbos);
	
	mysqli_query($mysqli,"update knj_kegiatan set id_j_bos=$bos[0] where kegiatan_member=$data[0]");
	echo("update knj_kegiatan set id_j_bos=$bos[0] where kegiatan_member=$data[0]<br>");
}




?>


	