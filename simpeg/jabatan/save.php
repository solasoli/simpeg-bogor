<?php 
extract($_POST);
include "db.php";
$q = "update pegawai set id_j = $id_j where id_pegawai = $id_pegawai";
if(mysql_query($q))
	echo "Update berhasil";	
?>