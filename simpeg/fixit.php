<?

include("konek.php");
$q=mysqli_query($mysqli,"select * from sk2 where id_kategori_sk=10 and tgl_sk='2010-12-09' and id_j>0");
while($data=mysqli_fetch_array($q))
{
mysqli_query($mysqli,"update sk set id_j=$data[id_j] where id_sk=$data[0]");	
}
echo("done");
?>