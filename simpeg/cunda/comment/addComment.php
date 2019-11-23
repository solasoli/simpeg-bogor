<?php
extract($_POST);
require_once("../../konek.php");

//$kapan = date('Y-m-d H:i:s');
//$kapan = now();
if($parent_id == NULL)
	$parent_id = 'NULL';

$q = "INSERT INTO post(id_pegawai, parent_id,  msg)
			VALUES($id_pegawai, $parent_id, '".addslashes($message)."')";
			//echo $q;
$result = mysqli_query($mysqli,$q);
//mail('cunda.dwi.s@gmail.com', 'SIMPEG Comment', $message);
 
?>