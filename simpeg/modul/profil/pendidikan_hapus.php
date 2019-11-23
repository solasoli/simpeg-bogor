<?php
require_once("../../konek.php");

$query = "delete from pendidikan where id_pendidikan = ".$_POST['id_pendidikan'];
if(mysqli_query($mysqli, $query)){
	echo "1";
}else{
	echo "gagal hapus "+mysqli_error();
}
