<?php
extract($_POST);
include("konek.php");
$qskpd=mysqli_query($mysqli,"select id_skpd from unit_kerja where id_unit_kerja=$unit");
$skpd=mysqli_fetch_array($qskpd);

$qcp=mysqli_query($mysqli,"select nama,tingkat,judul from proper inner join pegawai on  pegawai.id_pegawai=proper.id_pegawai and tahun=$lp");

echo("<div class='table-responsive'><table class='table table-bordered'><tr><td>Nama </td><td>Diklat PIM</td><td>Judul</td></tr>");
while($cp=mysqli_fetch_array($qcp))
{
echo("<tr><td nowrap >$cp[0]</td><td >$cp[1]</td><td >$cp[2]</td>");

echo("</td></tr>");
}
echo("</table></div>");
?>