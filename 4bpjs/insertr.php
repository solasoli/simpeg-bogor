<?php
extract($_POST);
extract($_GET);

mysqli_query($link,"insert into ruangan (lantai,ruang,ruangan,id_pegawai) values ('$lantai','$ruang','$ruangan',$pegawai)");


include("ruangan.php");

?>