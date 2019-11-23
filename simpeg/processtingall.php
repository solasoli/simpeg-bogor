<?php
extract($_POST);
include("konek.php");
//echo("lp = $lp unit $unit");

$qbidang=mysqli_query($mysqli,"select id from institusi_pendidikan where institusi like '$lp'");
$ins=mysqli_fetch_array($qbidang);



$qcp=mysqli_query($mysqli,"select nama,pendidikan_terakhir.tingkat_pendidikan,pendidikan_terakhir.jurusan_pendidikan,pendidikan_terakhir.lembaga_pendidikan,pendidikan_terakhir.tahun_lulus from pendidikan_terakhir  inner join pegawai on pegawai.id_pegawai = pendidikan_terakhir.id_pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja inner join pendidikan on pendidikan.id_pendidikan=pendidikan_terakhir.id_pendidikan where flag_pensiun=0  and id_institusi=$ins[0] and pendidikan_terakhir.level_p<7 group by pegawai.id_pegawai order by pendidikan_terakhir.level_p, pendidikan_terakhir.tahun_lulus");





echo("<div class='table-responsive'><table class='table table-bordered'><tr><td>Nama </td><td>Tingkat Pendidikan </td><td>Jurusan </td><td>Lembaga Pendidikan </td><td> Tahun Lulus </td></tr>");
while($cp=mysqli_fetch_array($qcp))
{

echo("<tr><td nowrap >$cp[0]</td><td >$cp[1]</td><td >$cp[2]</td><td >$cp[3]</td><td >$cp[4]</td>");

echo("</td></tr>");
}
echo("</table></div>");
?>