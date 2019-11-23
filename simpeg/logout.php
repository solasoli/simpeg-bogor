<?php
include("konek.php");
$id=$_REQUEST['id'];
mysqli_query($mysqli,"update pegawai set my_status='-' where id_pegawai=$id");
session_start();
session_destroy();
header('location:index.php');
?>