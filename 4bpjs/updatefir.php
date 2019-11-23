<?php
extract($_POST);
extract($_GET);

$ida=substr($aset,0,10);
$qaset=mysqli_query($link,"select id from kode_barang where kodebarang = '$ida'");

$aset=mysqli_fetch_array($qaset);

mysqli_query($link,"update aset set id_barang=$aset[0] ,tahun_beli = $tahun ,qty = $jumlah ,harga_satuan = $harga ,kondisi_barang ='$kondisi',merek_tipe = '$model' ,bahan =  '$bahan',id_ruangan=$ru  where id=$ide");

//echo("update aset set id_barang=$aset[0] ,tahun_beli = $tahun ,qty = $jumlah ,harga_satuan = $harga ,kondisi_barang ='$kondisi',merek_tipe = '$model' ,bahan =  '$bahan',id_ruangan=$ru  where id=$ide");
echo("<div align=center>Asset sudah didistribusikan ke dalam ruangan silahkan periksa pada menu Kartu Inventaris Ruangan </div>");
include("fir.php");

?>