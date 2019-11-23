<?php
extract($_POST);
include("konek.php");
//echo("lp = $lp unit $unit");
$qskpd=mysqli_query($mysqli,"select id_skpd from unit_kerja where id_unit_kerja=$unit");
$skpd=mysqli_fetch_array($qskpd);
if($lp!='Staf')
{
$kata=explode(" ",$lp);

$qcp=mysqli_query($mysqli,"select nama,jabatan.jabatan,pegawai.id_j,nama_baru from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja inner join jabatan on jabatan.id_j=pegawai.id_j where flag_pensiun=0 and pegawai.id_j>0 and jenjab like 'struktural' and eselon like '$kata[1]'");
	
}
else
{

$qcp=mysqli_query($mysqli,"select nama,pegawai.id_j,nama_baru from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where flag_pensiun=0 and id_j is null and jenjab like 'struktural' ");
}
echo("<div class='table-responsive'><table class='table table-bordered'><tr><td>Nama </td><td>Jabatan </td><td>Unit Kerja </td></tr>");
while($cp=mysqli_fetch_array($qcp))
{
if(!is_numeric($cp['id_j']))
$cp[1]="Staf Pelaksana";
echo("<tr><td nowrap >$cp[0]</td><td >$cp[1]</td><td >$cp[3]</td>");

echo("</td></tr>");
}
echo("</table></div>");
?>