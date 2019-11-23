<?php 
include_once "konek.php";
extract($_POST);

$q = "UPDATE berkas SET status = '$status'
	  WHERE id_berkas = $id_berkas";
	  echo $q;
mysql_query($q);	  
?>