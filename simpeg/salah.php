<?
include("konek.php");
$id=$_REQUEST['id'];
mysql_query("delete from riwayat_mutasi_kerja where id_riwayat=$id");
include("ceklist.php");

?>