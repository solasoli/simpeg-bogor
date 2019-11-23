<?php
include("koncil.php");
extract($_GET);
$countriesid = $id ;

//cek id berkas
$id_berkas = mysqli_fetch_object(mysqli_query($con,"select id_berkas from sk where id_sk = '".$idsk."'"))->id_berkas;

$isi_berkas = mysqli_fetch_object(mysqli_query($con,"select file_name from isi_berkas where id_berkas = '".$id_berkas."'"));
$id_isi_berkas = @$isi_berkas->id_isi_berkas;
$file_name = @$isi_berkas->file_name;


//echo '<script type="text/javascript">alert("id berkas ' . $id_berkas . ', dan file_name = '.$file_name.'");

try{


	mysqli_query($con,"BEGIN");
	//hapus isi berkas
	mysqli_query($con,"delete from isi_berkas where id_isi_berkas = '".$id_isi_berkas."'");
	if(file_exists("../simpeg/Berkas/".$file_name)){
		unlink("../simpeg/Berkas/".$file_name);
	}

	$q = mysqli_query($con,"select id_kategori_sk from sk where id_sk =$idsk");
	$data = mysqli_fetch_array($q);
	
	mysqli_query($con,"delete from berkas where id_berkas = '".$id_berkas."'");
	mysqli_query($con,"delete from sk where id_sk =$idsk ");
	mysqli_query($con,"delete from riwayat_mutasi_kerja where id_sk = $idsk");

	if($data[0] == 34){
		mysqli_query($con,"delete from dpk where id_sk =$idsk ");
	}elseif($data[0] == 35){
		mysqli_query($con,"delete from pindah_instansi where id_sk =$idsk ");
	}

	mysqli_query($con,"COMMIT");
	echo '<script type="text/javascript">alert("menghapus file = '.$file_name.'" berhasil);</script>';
	echo("<iframe name=bebas width=100% height=520 src=dock2.php?id=$countriesid frameborder=0 scrolling=auto /> </iframe> ");
}catch(exception $e){
	mysqli_query($con,"ROLLBACK");
	echo 'Message: ' .$e->getMessage();
}
/*
if(mysqli_query($con,"delete from sk where id_sk =$idsk ")){
	
	//unlink();
	echo "berhasil";
	
	echo("<iframe name=bebas width=100% height=520 src=dock2.php?id=$countriesid frameborder=0 scrolling=auto /> </iframe> ");
	
}else{
	echo "gagal hapus berkas";
	
}
*/

//198504132011011002-81820-142763.pdf