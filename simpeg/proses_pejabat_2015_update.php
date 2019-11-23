<?php

include 'konek.php';


if($_POST['id_j_old']){
	
	//echo $_POST['id_j_old']." dipasangkan dengan ".$_POST['id_j'];
	
	$sql = "update jabatan set id_j_old = ".$_POST['id_j_old']." where id_j = ".$_POST['id_j'];
	
	if(mysql_query($sql)){
		echo "1";
	}else{
		echo "0";
	}
	
}else{
	
	echo "tidak ada post";
}
