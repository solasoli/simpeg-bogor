<?
include("konek.php");
extract($_POST);
$q=mysql_query("update pegawai set telepon='$t',ponsel='$p',email='$email' where id_pegawai=$id");
include("pu.php");
?>