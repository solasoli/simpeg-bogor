<?php

include("koncil.php");
extract($_GET);
$countriesid = $id ;

$id_berkas = mysqli_fetch_object(mysqli_query($con,"select id_berkas from sk where id_sk = '".$idsk."'"))->id_berkas;

$id_berkas = mysqli_fetch_object(mysqli_query($con,"select id_berkas from sk where id_sk = '".$idsk."'"))->id_berkas;

$isi_berkas = mysqli_fetch_object(mysqli_query($con,"select file_name, id_isi_berkas from isi_berkas where id_berkas = '".$id_berkas."'"));
$id_isi_berkas = $isi_berkas->id_isi_berkas;
$file_name = $isi_berkas->file_name;


try{

	$connection = ssh2_connect('103.14.229.15');
	ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
	$sftp = ssh2_sftp($connection);
	$uploaddir = '/var/www/html/simpeg/berkas/';

	mysqli_query($con,"BEGIN");
	//hapus isi berkas
	mysqli_query($con,"delete from isi_berkas where id_isi_berkas = '".$id_isi_berkas."'");
	ssh2_sftp_unlink($sftp, $uploaddir.$file_name);
/*
  if(file_exists("../simpeg/Berkas/".$file_name)){
		unlink("../simpeg/Berkas/".$file_name);
	}
*/
	$q = mysqli_query($con,"select id_kategori_sk from sk where id_sk =$idsk");
	$data = mysqli_fetch_array($q);

	mysqli_query($con,"delete from berkas where id_berkas = '".$id_berkas."'");
	mysqli_query($con,"update sk set id_berkas = NULL where id_sk =$idsk ");


	mysqli_query($con,"COMMIT");
	echo '<script type="text/javascript">alert("menghapus file = '.$file_name.'" berhasil);</script>';
  echo "Berhasil";
  //echo("<iframe name=bebas width=100% height=520 src=dock2.php?id=$countriesid frameborder=0 scrolling=auto /> </iframe> ");
}catch(exception $e){
	mysqli_query($con,"ROLLBACK");
	echo 'Message: ' .$e->getMessage();
}
