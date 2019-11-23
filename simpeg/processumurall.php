<?php
extract($_POST);
include("konek.php");
//echo("lp = $lp unit $unit");

$umur=explode(" ",$lp);

$qcp=mysqli_query($mysqli,"select nama,tgl_lahir,nama_baru from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where flag_pensiun=0  and floor(datediff(curdate(),tgl_lahir)/365)=$umur[0] order by tgl_lahir desc");
	

echo("<div class='table-responsive'><table class='table table-bordered'><tr><td>Nama </td><td>Tanggal Lahir </td><td>Unit Kerja </td></tr>");
while($cp=mysqli_fetch_array($qcp))
{
$t1=substr($cp[1],8,2);
$b1=substr($cp[1],5,2);
$th1=substr($cp[1],0,4);
echo("<tr><td nowrap >$cp[0]</td><td >$t1-$b1-$th1</td>");

echo("</td><td>$cp[2] </td></tr>");
}
echo("</table></div>");
?>