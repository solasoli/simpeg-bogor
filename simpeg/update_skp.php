<?php
include("konek.php");

$q=mysqli_query($mysqli,"select id_pegawai from nilai_skp");
while($data=mysqli_fetch_array($q))
{
$q2=mysqli_query($mysqli,"select pegawai.id_j,id_skpd from pegawai inner join jabatan on jabatan.id_j=pegawai.id_j inner join unit_kerja on unit_kerja.id_unit_kerja=jabatan.id_unit_kerja where pegawai.id_pegawai=$data[0]");
$ata=mysqli_fetch_array($q2);

mysqli_query($mysqli,"update nilai_skp set id_j=$ata[0],id_skpd=$ata[1] where id_pegawai=$data[0]");

}

echo("done");

?>