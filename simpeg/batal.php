<?php
include("konek.php");
$id=$_REQUEST['id'];
mysqli_query($mysqli,"delete from mutasi_jabatan where id_mutjab=$id");
include("pegawai.php");
?>
