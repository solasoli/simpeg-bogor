<?php
extract($_POST);
include("../../konek.php");
mysql_query("insert into proper (judul) values ($judul)");

?>