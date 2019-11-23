<?php
include("konek.php");
extract($_POST);
for($i=1;$i<=$total;$i++)
{
$peg=$_POST["idp".$i];
$anj=$_POST["jfu".$i];
if($anj>0)
{
mysql_query("insert into anjab_pegawai (id_anjab,id_pegawai) values ($anj,$peg)");
}

}
echo("<div align=center>input nama jfu berhasil </div>");
include("anjab_pegawai.php");
?>