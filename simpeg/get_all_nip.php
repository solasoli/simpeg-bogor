<?php 
$query = $_GET['query'];

$q = "SELECT nama
	  from pegawai 
	  where flag_pensiun = 0 AND nip_baru like '$query%'";
$rs = mysqli_query($mysqli,$q);
$result = aray();
while($r = mysqli_fetch_array($rs))
	$result[] = $r[0];

print json_encode($result);
?>