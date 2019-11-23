<?php
extract($_POST);
extract($_GET);


mysqli_query($link,"update   ruangan set lantai='$lantai',ruang='$ruang',ruangan='$ruangan',id_pegawai=$pegawai where id=$ide");

include("ruangan.php");

?>