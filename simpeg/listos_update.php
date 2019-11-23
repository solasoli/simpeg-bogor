<?php
include 'konek.php';
if($_POST['os']){
	
	//echo $_POST['id_j_old']." dipasangkan dengan ".$_POST['id_j'];
	$sql =	"update pegawai set os='".$_POST['os']."', ponsel='".$_POST['hp']."' where id_pegawai=$idp".$_POST['idp'];
		
	if(mysqli_query($mysqli,$sql)){
		echo "1";		
	}else{
		echo "0";
	}
	
}else{
	
	echo "tidak ada post";
}
