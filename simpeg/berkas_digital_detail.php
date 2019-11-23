<?php
extract($_POST);
include "konek.php";

$q = "SELECT * 
      FROM isi_berkas i
      WHERE i.id_berkas = $id_berkas 
      ";
    //echo $q;
$q = mysqli_query($mysqli,$q);

while($r = mysqli_fetch_array($q)){
  echo "<img src=\"berkas/$nip-$id_berkas-$r[id_isi_berkas].jpg\"  width=\"700\" /><br/>";
}
?>                                                                                     
