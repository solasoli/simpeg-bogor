<?php
extract($_POST);
extract($_GET);
$ida=substr($aset,0,8);
$qaset=mysqli_query($link,"select id from kode_barang where kode = '$ida'");
$aset=mysqli_fetch_array($qaset);
mysqli_query($link,"insert into pengaduan (id_pegawai,id_barang,tgl,pengaduan) values ($_SESSION[id],$aset[0],CURDATE(),'$keluhan')");
$ida=mysqli_insert_id($link);

$pail=$_FILES['gambar'];
if($pail['size']>0)
{
$nama=$ida.".jpg";
mysqli_query($link,"update pengaduan set file_pengaduan='$nama' where id=$ida");
move_uploaded_file($pail['tmp_name'],"./gambar/".$nama);
}
echo("<div align=center>Laporan Sudah Disampaikan silahkan periksa menu daftar pengaduan </div>");
?>