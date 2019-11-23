<?php
include('class/keluarga_class.php');
include('konek.php');
include('library/format.php');

$keluarga 		= & new Keluarga_class;
	
	$id_peg 			= $_POST['id_pegawai'];
	$id_k 				= $_POST['id_keluarga'];
	$prestasi 				= $_POST['prestasi'];
	$sert = $_FILES['piagam'];

    mysqli_query($mysqli,"insert into prestasi_keluarga (id_keluarga,prestasi) values ($id_k,'$prestasi')");
	$idp=mysqli_insert_id();
	
	if($sert['size']>0)
	{
	
	 $namafile = "$id_k-$idp.pdf";
            mysqli_query($mysqli,"update prestasi_keluarga set url='$namafile' where id=$idp");
			$tmp=$sert['tmp_name'];
            move_uploaded_file($tmp, "./prestasianak/$namafile");
	
	}
	
	header("Location:index3.php?x=box.php&od=".$id_peg);

	
	
?>
