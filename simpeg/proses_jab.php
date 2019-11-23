<?php
include("konek.php");

$q = strtolower($_GET["q"]);
if (!$q) return;

$skr=date("2017");

$sql = mysqli_query($mysqli,"select jabatan from jabatan where jabatan LIKE '%$q%' and tahun='$skr' ");
//echo("select jabatan from jabatan where jabatan LIKE '%$q%' and tahun='$skr'");
while($r = mysqli_fetch_array($sql)) {	
	$nama_negara = $r['jabatan'];
	echo "$nama_negara \n";
}
?>
