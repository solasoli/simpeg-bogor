<?php
extract($_POST);
extract($_GET);
mysqli_query($link,"delete from ruangan where id=$id");
include("ruangan.php");

?>