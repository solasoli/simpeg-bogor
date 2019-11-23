<?php
include("konek.php");
$q=mysqli_query($mysqli,"select * from mutasi_jabatan");
while($data=mysqli_fetch_array($q))
{
$qc=mysqli_query($mysqli,"select sk.id_pegawai,nama from sk 	inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where sk.id_j=$data[2] and flag_pensiun=0");



$cek=mysqli_fetch_array($qc);
if($cek[0]!=NULL)
{
$qcari=mysqli_query($mysqli,"select count(*) from mutasi_jabatan	where id_pegawai=$cek[0]");
$cari=mysqli_fetch_array($qcari);

if($cari[0]==0)
echo("&nbsp;<a href=pegawai.php?peg=$cek[0]> $cek[1] </a><br>");
	
}
	
	
}


?>