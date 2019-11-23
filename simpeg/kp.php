<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from kepang");
while($data=mysqli_fetch_array($q))
{
	/* edited
	if($data[0]>=562)
	$p='Gubernur Jawa Barat';
	else
	$p='Walikota Bogor';
mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,tmt,keterangan,pemberi_sk,pengesah_sk) values ($data[1],5,'$data[5]','$data[7]','$data[6]','$data[4],$data[8],$data[9]','$p','$p')");	

*/
mysqli_query($mysqli,"update pegawai set pangkat_gol='$data[4]' where id_pegawai=$data[1]");
mysqli_query($mysqli,"update kepang set flag=2 where id_kepang=$data[0]");
}
echo("done");
?>