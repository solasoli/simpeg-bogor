<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from keluarga");
$i=1;
while($data=mysqli_fetch_array($q))
{
$nom=$i;
mysqli_query($mysqli,"update keluarga set id_keluarga=$nom where id_keluarga=$data[0]");
//echo("update keluarga set id_keluarga=$nom where id_keluaraga=$data[0]<br>");
$i++;
}

?>