<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from jabatan where Tahun=2011");

while($data=mysqli_fetch_array($q))
{
	$q0=mysqli_query($mysqli,"select id_j,id_pegawai from sk where id_kategori_sk=10 and id_j=$data[0] order by  tmt desc");
	$cok=mysqli_fetch_array($q0);
	
	

	
	mysqli_query($mysqli,"update pegawai set jabatan='$data[1]' where id_pegawai=$cok[1]");
	echo("update pegawai set jabatan='$data[1]' where id_pegawai=$cok[1]");

}
echo("done");
?>