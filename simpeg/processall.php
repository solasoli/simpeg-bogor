<?php
extract($_POST);
include("konek.php");




if(trim($lp)=="S3")
$p=1;
elseif(trim($lp)=="S2")
$p=2;
elseif(trim($lp)=="S1")
$p=3;
elseif($lp=="D3")
$p=4;
elseif($lp=="D2")
$p=5;
elseif($lp=="D1")
$p=6;
elseif($lp=="SMA")
$p=7;
elseif($lp=="SMP")
$p=8;
elseif($lp=="SD")
$p=9;



$qcp=mysqli_query($mysqli,"select nama,lembaga_pendidikan,jurusan_pendidikan,tahun_lulus,level_p,nama_baru from pendidikan_terakhir inner join pegawai on pegawai.id_pegawai=pendidikan_terakhir.id_pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where flag_pensiun=0 and level_p=$p order by tahun_lulus");




echo("<div class='table-responsive'><table class='table table-bordered'><tr><td>Nama </td><td>Institusi </td><td>Jurusan </td><td> Tahun Lulus</td><td> Unit Kerja </td></tr>");
while($cp=mysqli_fetch_array($qcp))
{
echo("<tr><td nowrap >$cp[0]</td><td >$cp[1]</td><td >$cp[2] </td><td nowrap>"); 


if($cp[3]==0)
echo " Tidak Diketahui ";
else
echo "$cp[3]";


echo("</td><td> $cp[5]</td></tr>");
}
echo("</table></div>");
?>