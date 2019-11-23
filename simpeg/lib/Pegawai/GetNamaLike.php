<?php

extract($_GET);

if(file_exists("../PegawaiRepository.php"))
	include_once "../PegawaiRepository.php";

if(file_exists("../../konek.php"))
	include_once "../../konek.php";

$namas = getNamaPegawaiLike($q);
while($nama = mysql_fetch_array($namas)){
	echo $nama[nama].chr(10);
}
?>