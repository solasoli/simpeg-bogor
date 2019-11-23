<?php 

include("konek.php");

$sql = "select * from keluarga where id_keluarga = ".$_POST['id_keluarga'];

$keluarga = mysqli_fetch_array(mysqli_query($mysqli,$sql));

if($keluarga){
	echo json_encode($keluarga);
}