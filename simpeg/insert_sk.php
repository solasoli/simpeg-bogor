<?php
//print_r($_POST);
extract($_POST);
include_once "konek.php";

$q = "SELECT COUNT(*) 
	  FROM sk s
	  WHERE id_kategori_sk = 6
	  AND id_pegawai = $id_pegawai";
	  
$q = mysqli_query($mysqli,$q);

$q = mysqli_fetch_array($q);
if($q[0] < 1)
{	  
	$keterangan = $pangkat_gol.",".$maker_tahun.",".$maker_bulan;
	
	$q = "INSERT INTO sk (
			id_pegawai,
			id_kategori_sk,
			no_sk,
			tgl_sk,
			pemberi_sk,
			pengesah_sk,
			keterangan,
			tmt,
			id_j,
			id_berkas
		  ) 
		  VALUES (
			 '$id_pegawai',
			 '6',
			 '$no_sk',
			 '$tanggal_sk',
			 '$pemberi_sk',
			 '$pengesah_sk',
			 '$keterangan',
			 '$tmt_sk',
			 '0',
			 '$id_berkas'
		  )";
	
	mysqli_query($mysqli,$q);
	echo "Data SK berhasil ditambahkan";
}
else
{
	echo "Pegawai ini sudah memiliki data SK CPNS.";
}

?>
