<?php
extract($_POST);
extract($_GET);
mysqli_query($link,"delete from  aset where id=$id");
include("kir.php");

?>