<?php
extract($_POST);
extract($_GET);
$ida=substr($aset,0,10);
$qaset=mysqli_query($link,"select id from kode_barang where kodebarang = '$ida'");

$aset=mysqli_fetch_array($qaset);


mysqli_query($link,"insert into aset (id_barang,id_ruangan,tahun_beli,qty,harga_satuan,kondisi_barang,merek_tipe,bahan) values ($aset[0],$ru,$tahun,$jumlah,$harga,'$kondisi','$model','$bahan')");

include("kir.php");

?>