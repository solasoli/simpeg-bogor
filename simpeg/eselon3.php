<style type="text/css">
body,td,th {
	font-family: tahoma;
	font-size: 11px;
}
</style>
<table width="500" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td>NO</td>
    <td>Jabatan</td>
    <td>Nama</td>
    <td>Pendidikan Terakhir</td>
    <td>Jurusan</td>
    <td nowrap>Lulus Tahun</td>
  </tr>

<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from jabatan where tahun=2011 and eselon like 'III%'");
	$i=1;
while($data=mysqli_fetch_array($q))
{
	$qj=mysqli_query($mysqli,"select nama,sk.id_pegawai from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where sk.id_j=$data[0] order  by tmt desc"); 
	$ja=mysqli_fetch_array($qj);
	
	$qp=mysqli_query($mysqli,"Select tingkat_pendidikan,tahun_lulus,jurusan_pendidikan from pendidikan where id_pegawai =$ja[1] order by level_p");
	$pen=mysqli_fetch_array($qp);
	if($pen[1]==0)
	$pen[1]="-";
	echo("  <tr>
    <td>$i</td>
    <td nowrap>$data[1]</td>
    <td nowrap>$ja[0]</td>
    <td nowrap>$pen[0]</td>
    <td nowrap>$pen[2]</td>
    <td nowrap>$pen[1]</td>
  </tr>
");
	
	
	$i++;

	
}

?>
</table>