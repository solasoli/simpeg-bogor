<?php



include("konek.php");

$q=mysqli_query($mysqli,"select * from iseng");

while($data=mysqli_fetch_array($q))

{

mysqli_query($mysqli,"update pegawai set jabatan='$data[1]' where id_pegawai=$data[0]");

if(substr($data[2],-1)==' ')

$data[2]=substr($data[2],0,-1);

$qcd=mysqli_query($mysqli,"select id_unit_kerja from unit_kerja where nama_baru like '$data[2]%' ");

echo("select id_unit_kerja from unit_kerja where nama_baru like '$data[2]%' <br>");

$ata=mysqli_fetch_array($qcd);

mysqli_query($mysqli,"update riwayat_mutasi_kerja set id_unit_kerja =$ata[0] where id_pegawai=$data[0]");



}



?>