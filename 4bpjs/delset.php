<?php
extract($_POST);
extract($_GET);
$ay=date("Y-m-d");
mysqli_query($link,"update aset set date_delete='$ay',kondisi_barang='Rusak Berat' where id=$id");
echo("<div align=center> Data asset sudah dihapus dan dapat dilihat pada menu data asset terhapus</div>");
include("rusak.php");

?>