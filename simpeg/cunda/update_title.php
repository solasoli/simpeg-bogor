<?php
mysql_connect("localhost", "root", "51mp36") or die;
mysql_select_db("simpeg");

$rs = mysql_query("SELECT nama FROM PEGAWAI WHERE RIGHT(nama, 3) = ' SE' OR WHERE RIGHT(nama, 3) = ',SE'");

while($r = mysql_fetch_array($rs))
{
echo $r[nama]."<br/>";
}
?>