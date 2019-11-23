<?php
include("konek.php");
$q=mysqli_query($mysqli,"select * from mutasi_jabatan ");
while($data=mysqli_fetch_array($q))
{
$qui=mysqli_query($mysqli,"select id_unit_kerja,jabatan from jabatan where id_j=$data[2] ");
$uk=mysqli_fetch_array($qui);
mysqli_query($mysqli,"update current_lokasi_kerja set id_unit_kerja=$uk[0] where id_pegawai=$data[1] ");
mysqli_query($mysqli,"update pegawai set id_j=$data[2],jabatan='$uk[1]' where id_pegawai=$data[1]");
echo("update pegawai set id_j=$data[2],jabatan='$uk[1]' where id_pegawai=$data[1] <br>");



}
echo("done");

?>