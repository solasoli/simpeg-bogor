<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style></head>

<body>

<table width="700" border="1" cellpadding="5" cellspacing="0" bordercolor="#000000">
  <tr>
    <td>nama</td>
    <td>nip lama </td>
    <td>nip baru </td>
	<td>Jenjang Jabatan</td>
    <td>skpd</td>
  </tr>
  <?
include("konek.php");
$q=mysqli_query($mysqli,"select nama,nip_lama,nip_baru,id_pegawai,jenjab from pegawai where flag_pensiun=0 and jenjab like '%fungsional%'");
while($data=mysqli_fetch_array($q))
{

$q2=mysqli_query($mysqli,"select id_unit_kerja from riwayat_mutasi_kerja where id_pegawai=$data[3] order by id_riwayat desc");
$unit=mysqli_fetch_array($q2);
$q3=mysqli_query($mysqli,"select nama_baru from unit_kerja where id_unit_kerja=$unit[0] and nama_baru not like '%Dinas Kesehatan%' and nama_baru not like '%dinas pendidikan%' and nama_baru not like '%SD%' and nama_baru not like '%SMP%' and nama_baru not like '%TK%' and nama_baru not like '%SMA%' and nama_baru not like '%SMK%' and nama_baru not like '%MAN%' and nama_baru not like '%belum%' and nama_baru not like '%MTS%' and nama_baru not like '%kecamatan%' ");
if($q3)
$dapet=mysqli_fetch_array($q3);

if($dapet[0]!=NULL)
{
echo("<tr>
<td>$data[0]</td>
<td>&nbsp;$data[1]</td>
<td>&nbsp;$data[2]</td>
");
echo("
<td>$data[4]</td>
<td>$dapet[0]</td></tr>");
}


}
?>

</table>
</body>
</html>
