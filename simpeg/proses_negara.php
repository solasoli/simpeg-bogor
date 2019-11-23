<?php
include("konek.php");

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = mysqli_query($mysqli,"select nama,id_pegawai,nip_baru from pegawai where nama LIKE '%$q%' or nip_baru LIKE '%$q%'");
while($r = mysqli_fetch_array($sql)) {
	$nama_negara = $r['nama'];
	echo "$nama_negara $r[2]|$r[1]\n";
}
?>
