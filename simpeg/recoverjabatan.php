<?php
mysqli_connect("simpeg.db.kotabogor.net","simpeg", "Madangkara2017");
mysqli_select_db("simpeg");
$q=mysqli_query($mysqli,"select pegawai.id_pegawai,unit_kerja.id_unit_kerja from pegawai inner join jabatan on jabatan.id_j=pegawai.id_j inner join unit_kerja on jabatan.id_unit_kerja=unit_kerja.id_unit_kerja where unit_kerja.tahun=2015 and flag_pensiun=0 and pegawai.id_j is not null");

while($data=mysqli_fetch_array($q))
{
mysqli_query($mysqli,"update current_lokasi_kerja set id_unit_kerja=$data[1] where id_pegawai=$data[0]");

}
echo("done");
?>