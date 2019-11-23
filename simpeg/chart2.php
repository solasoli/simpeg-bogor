<?php
$s = $_REQUEST['s'];
$id = $_REQUEST['id'];
$e = $_REQUEST['e'];
$thn=$_REQUEST['thn'];
include("./php-ofc-library/open_flash_chart_object.php");
open_flash_chart_object( 650, 250,"http://". $_SERVER['SERVER_NAME'] ."/simpeg/grafik42.php", false );
?>