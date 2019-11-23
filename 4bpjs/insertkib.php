<?php
extract($_POST);
extract($_GET);
$ida=substr($aset,0,10);
$qaset=mysqli_query($link,"select id from kode_barang where kodebarang = '$ida'");

$aset=mysqli_fetch_array($qaset);


mysqli_query($link,"insert into aset (id_barang,no_reg,ukuran,bahan,tahun_beli,no_pabrik,no_rangka,no_mesin,no_polisi,BPKB,asal_usul,qty,harga_satuan,keterangan,merek_tipe) values ($aset[0],'$reg','$ukuran','$bahan',$tahun,'$pabrik','$rangka','$mesin','$polisi','$bpkb','$asal',$jumlah,$harga,'$keterangan','$model')");

echo("<div align=center>Aset berhasil dicatat silahkan periksa pada menu Kartu inventaris Barang </div>");
include("fib.php");

?>