<?
include("konek.php");
extract($_GET);
$qb=mysqli_query($mysqli,"select file_name from isi_berkas where id_berkas=$idb");
//echo("select file_name from isi_berkas where id_berkas=$idb");
echo("<table border=0 cellpadding=0 cellspacing=0>");
while($alay=mysqli_fetch_array($qb))
{
$do=strstr($alay[0], 'Berkas');
$asli=basename($do);
echo("<tr><td><img src=./Berkas/$asli  width=100%/></td></tr>");

}
echo("</table>");
?>