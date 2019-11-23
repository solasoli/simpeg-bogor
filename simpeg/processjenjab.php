<?php
extract($_POST);
include("konek.php");
//echo("lp = $lp unit $unit");
$qskpd=mysqli_query($mysqli,"select id_skpd from unit_kerja where id_unit_kerja=$unit");
$skpd=mysqli_fetch_array($qskpd);

$qcp=mysqli_query($mysqli,"select nama,jenjab,jabatan,nama_baru from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where flag_pensiun=0 and id_skpd=$skpd[0] and jenjab like '$lp' order by jabatan");

	
echo("<div class='table-responsive'><table class='table table-bordered'><tr><td>Nama </td><td>Jenjang Jabatan </td><td>Jabatan </td><td> Unit Kerja </td></tr>");
while($cp=mysqli_fetch_array($qcp))
{
echo("<tr><td nowrap >$cp[0]</td><td >$cp[1]</td><td >$cp[2]</td><td >$cp[3]</td>");

echo("</td></tr>");
}
echo("</table></div>");
?>