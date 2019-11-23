<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from sk where id_sk>=178015 and id_kategori_sk=10 and id_j>0");
while($data=mysqli_fetch_array($q))
{
$q1=mysqli_query($mysqli,"select * from jabatan where id_j=$data[9]");
$ta=mysqli_fetch_array($q1);

mysqli_query($mysqli,"update pegawai set jabatan='$ta[1]',eselonering='$ta[4]'	where  id_pegawai=$data[1]");
echo("update pegawai set jabatan='$ta[1]',eselonering='$ta[4]'	where  id_pegawai=$data[1]<br>");

}
echo("done");

?>
