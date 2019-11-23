<?php


include("koncil.php");
extract($_GET);
$countriesid = $id ;
if(mysqli_query($con, "delete from pendidikan where id_pendidikan =$id_pendidikan and id_pegawai = $id")){

	echo "berhasil";

	echo("<iframe name=bebas width=100% height=520 src=dock2.php?id=$countriesid frameborder=0 scrolling=auto /> </iframe> ");

}else{
	echo "gagal hapus berkas";
}
