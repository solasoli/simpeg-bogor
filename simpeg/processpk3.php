<?php
extract($_POST);
include("konek.php");
$qskpd=mysqli_query($mysqli,"select id_skpd from unit_kerja where id_unit_kerja=$unit");
$skpd=mysqli_fetch_array($qskpd);

$qcp=mysqli_query($mysqli,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama,jabatan,nama_baru from survey_pengkom inner join pegawai on pegawai.id_pegawai=survey_pengkom.id_pegawai inner join current_lokasi_kerja on survey_pengkom.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on current_lokasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where jenis_kompetensi_teknis like '%$lp%'");

echo("<div class='table-responsive'><table class='table table-bordered'><tr><td>Nama </td><td>Jabatan</td><td>Unit Kerja</td></tr>");
while($cp=mysqli_fetch_array($qcp))
{
echo("<tr><td nowrap >$cp[0]</td><td >$cp[1]</td><td >$cp[2]</td>");

echo("</td></tr>");
}
echo("</table></div>");
?>