<?
extract($_POST);
include("koncil.php");
$q=mysql_query("select count(*) from pegawai where (nip_baru='$u' or nip_lama='$u') and password='$p'");

$cek=mysql_fetch_array($q);
if($cek[0]>0)
{
$q2=mysql_query("select pegawai.id_pegawai,id_unit_kerja from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where (nip_baru='$u' or nip_lama='$u') and password='$p'");
$cek2=mysql_fetch_array($q2);
if($cek2[1]==3566)
{	
	session_start();	
	//$_SESSION['user']='xxx';	
	$_SESSION['user']=$cek2;
	include("index2.php");	
}
else
{
echo("<div align=center ><h2>Anda Tidak Memiliki Akses Untuk Halaman ini </h2></div>");
include("index.html");	

}
}
else
{
echo("<div align=center ><h2>NIP atau Password salah </h2></div>");
include("index.html");	

}


?>