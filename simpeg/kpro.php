<?
include("konek.php");
extract($_GET);
mysql_query("update syarat_mutasi set flag=1 where id_syarat=$id");
include("adminkp.php");

?>