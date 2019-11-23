<?php
require_once "konek.php";
$query = "update pegawai set imei = NULL where id_pegawai = '".$_POST['id_pegawai']."'";
//$query = "update pegawai set imei = NULL where id_pegawai = 12388";
if(mysqli_query($mysqli,$query)){
	echo "1";
}else{
	echo "0";
}