<?
include"konek.php";
$q=mysqli_query($mysqli,"Select id_pegawai,id_j from sk where id_kategori_sk=10 and tmt like '2011%' order by tmt");
while($data=mysqli_fetch_array($q))
{


mysqli_query($mysqli,"update pegawai set id_j=$data[1] where id_pegawai=$data[0]");

}
echo("done");

?>