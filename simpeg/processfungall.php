<?php
extract($_POST);
include("konek.php");
//echo("select nama,jabatan,nama_baru from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja left join sertifikasi_guru on pegawai.id_pegawai=sertifikasi_guru.id_pegawai where flag_pensiun=0 and jenjab like 'fungsional' and jabatan like 'Guru' and sertifikasi.id is null order by jabatan");



if($lp!='Guru' or $lp!='Guru Sertifikasi' )
$qcp=mysqli_query($mysqli,"select nama,jabatan,nama_baru from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where flag_pensiun=0 and jenjab like 'fungsional' and jabatan like '$lp' order by jabatan");

if($lp=='Guru Sertifikasi')
$qcp=mysqli_query($mysqli,"select nama,jabatan,nama_baru from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja inner join sertifikasi_guru on pegawai.id_pegawai=sertifikasi_guru.id_pegawai where flag_pensiun=0 and jenjab like 'fungsional' and jabatan like 'Guru' order by jabatan");

if($lp=='Guru')
$qcp=mysqli_query($mysqli,"select nama,jabatan,nama_baru from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja left join sertifikasi_guru on pegawai.id_pegawai=sertifikasi_guru.id_pegawai where flag_pensiun=0 and jenjab like 'fungsional' and jabatan like 'Guru' and sertifikasi_guru.id is null order by jabatan");

	
echo("<div class='table-responsive'><table class='table table-bordered'><tr><td>Nama </td><td>Jabatan </td><td>Unit Kerja</td></tr>");
while($cp=mysqli_fetch_array($qcp))
{
echo("<tr><td nowrap >$cp[0]</td><td >$cp[1]</td><td >$cp[2]</td><td >$cp[3]</td>");

echo("</td></tr>");
}
echo("</table></div>");
?>