<?php

include("konek.php");

//echo $_POST['id_pegawai'];

$sql = "update pegawai set status_aktif = 'Aktif', flag_pensiun = 0 where status_aktif != 'Pensiun Reguler' and id_pegawai = '".$_POST['id_pegawai']."'";

if($query = mysqli_query($mysqli,$sql)){
	echo '1';
}else{
	echo '0';
}
