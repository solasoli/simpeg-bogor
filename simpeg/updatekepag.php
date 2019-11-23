<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from pegawai2 order by id_pegawai");
while($data=mysqli_fetch_array($q))
{
mysqli_query($mysqli,"update pegawai set pangkat_gol='$data[pangkat_gol]' where id_pegawai=$data[0]");
	
	
}
echo("done!");