<?php

include("../../konek.php");
extract($_POST);

//print_r($_POST);
//exit;	
$qcek=mysql_query("select count(*) from ijin_belajar where id_pegawai=$idp and tingkat_pendidikan=$pl");
$cek=mysql_fetch_array($qcek);
if($cek[0]==0 or $edit>0)
{	
	$sekarang=date("Y-m-d");
	if($edit==0)
		$sql = ("insert into ijin_belajar(id_pegawai,institusi_lanjutan,tingkat_pendidikan,jurusan,akreditasi,tgl_pengajuan,id_formasi) 
			values ($idp,'$ilanjutan',$pl,'$jlanjutan','$akr','$sekarang','$id_formasi')");
	else
	{
		$sql = ("update ijin_belajar set institusi_lanjutan='$ilanjutan',tingkat_pendidikan=$pl,jurusan='$jlanjutan',akreditasi='$akr' where id=$edit");
	
	}
	if(mysql_query($sql)){
		echo "Pengajuan Ijin Belajar Berhasil";
	}else{
		echo mysql_error() . $sql;
	}
	
	
}
else{
	echo $nama." sudah pernah mengajukan ijin belajar ";

}
