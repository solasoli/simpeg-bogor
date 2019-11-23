<?php
include("konek.php");
extract($_POST);
for($i=1;$i<=$total;$i++)
{
$peg=$_POST["idp".$i];
$anj=$_POST["jfu".$i];

$qcari=mysql_query("select id from anjab_master where id_jft=$anj");
$cari=mysql_fetch_array($qcari);

mysql_query("insert into anjab_pegawai (id_anjab,id_pegawai) values ($cari[0],$peg)");
//echo("insert into anjab_pegawai (id_anjab,id_pegawai) values ($cari[0],$peg)<br>");


}
echo("<div align=center>input nama jft berhasil </div>");
include("anjab_jft.php");
?>