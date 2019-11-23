<?php
require "koncil.php";
$query = "update pegawai set imei = NULL where id_pegawai = '".$_POST['id_pegawai']."'";

if(mysqli_query($con,$query)){
	echo "1";
}else{
	echo "0";
}