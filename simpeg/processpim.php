<?php
extract($_POST);
include("konek.php");
//echo("lp = $lp unit $unit");
$qskpd=mysqli_query($mysqli,"select id_skpd from unit_kerja where id_unit_kerja=$unit");
$skpd=mysqli_fetch_array($qskpd);
$pim=explode(" ",$lp);
if($pim[0]!='Belum')
{
$qcp=mysqli_query($mysqli,"select nama, nip_baru, jabatan.jabatan,nama_baru,tgl_diklat from diklat inner join pegawai on pegawai.id_pegawai = diklat.id_pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja inner join jabatan on jabatan.id_j=pegawai.id_j where flag_pensiun=0 and nama_diklat like '%Tk.".$pim[1]."' order by tgl_diklat");
$tanggal="Tanggal Diklat";
}
else
{
$qcp=mysqli_query($mysqli,"select nama, nip_baru, jabatan.jabatan,nama_baru,sk.tmt from pegawai p left join diklat on p.id_pegawai = diklat.id_pegawai inner join current_lokasi_kerja on p.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja inner join jabatan on jabatan.id_j=p.id_j inner join sk on sk.id_pegawai = p.id_pegawai where flag_pensiun=0 and diklat.id_pegawai is null and sk.tmt=(select min(tmt) from sk where id_kategori_sk=10 and sk.id_pegawai=p.id_pegawai) order by sk.tmt");
$tanggal="TMT Mutasi Jabatan";
}

echo("<div class='table-responsive'><table class='table table-bordered'>
		<tr><td>Nama </td><td>NIP</td></td><td>Jabatan </td><td>Unit Kerja </td><td>$tanggal</td></tr>");
while($cp=mysqli_fetch_array($qcp))
{
$t1=substr($cp[4],8,2);
$b1=substr($cp[4],5,2);
$th1=substr($cp[4],0,4);
echo("<tr><td nowrap >$cp[0]</td><td >$cp[1]</td><td >$cp[2]</td><td >$cp[3]</td><td >$t1-$b1-$th1</td>");

echo("</td></tr>");
}
echo("</table></div>");
?>
