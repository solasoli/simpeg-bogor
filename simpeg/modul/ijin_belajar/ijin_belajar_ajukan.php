<?php

include("konek.php");

$sql = "update ijin_belajar set approve = '".$_POST['status']."' where ijin_belajar.id = '".$_POST['id']."'";

if(mysql_query($sql)){
	echo "Berhasil";
}else{
	echo "Failed : ".$sql;
}