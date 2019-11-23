<?php


include("koncil.php");
extract($_GET);
$countriesid = $id ;

if(mysql_query("delete from keluarga where id_keluarga=$id_keluarga and id_pegawai = $id")){

	echo "berhasil";
	
	echo("<iframe name=bebas width=100% height=520 src=dock2.php?id=$countriesid frameborder=0 scrolling=auto /> </iframe> ");
	
}else{
	echo "gagal hapus berkas";
}