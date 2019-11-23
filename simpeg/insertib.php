<?php
include("konek.php");
extract($_POST);
if($jlanjutan!=""  and $jlanjutan!=NULL)
{
	
$qcek=mysqli_query($mysqli,"select count(*) from ijin_belajar where id_pegawai=$idp and tingkat_pendidikan=$pl");
$cek=mysqli_fetch_array($qcek);
if($cek[0]==0 or $edit>0)
{	
$sekarang=date("Y-m-d");
	if($edit==0)
	mysqli_query($mysqli,"insert into ijin_belajar(id_pegawai,institusi_lanjutan,tingkat_pendidikan,jurusan,akreditasi,tgl_pengajuan) values ($idp,'$ilanjutan',$pl,'$jlanjutan','$akr','$sekarang')");
	else
	{
	mysqli_query($mysqli,"update ijin_belajar set institusi_lanjutan='$ilanjutan',tingkat_pendidikan=$pl,jurusan='$jlanjutan',akreditasi='$akr' where id=$edit");
	
	}
	echo("<div align=center> Pengajuan Ijin Belajar Berhasil  </div>");
	
	include("ijinbelajar.php");
}
else
{
echo("<div align=center> $nama sudah pernah mengajukan ijin belajar  </div>");
include("ijinbelajar.php");	
}
}
else
{
	echo("<div align=center> Jurusan Lanjutan Belum terisi </div>");
include("ijinbelajar.php");	
}
?>