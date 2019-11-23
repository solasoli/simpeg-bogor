<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style></head>
<body>
<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from jabatan where id_unit_kerja=3595 order by level");
?>
<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td>No</td>
    <td>Nama</td>
    <td>NIP</td>
    <td>Jabatan</td>
    <td>Golongan</td>
    <td nowrap="nowrap">TMT Golongan </td>
  </tr>
  <?
  
  
$i=1;
while($data=mysqli_fetch_array($q))
{
$qp=mysqli_query($mysqli,"select id_pegawai  from sk where id_kategori_sk=10 and id_j=$data[0]");
$pa=mysqli_fetch_array($qp);

$qpeg=mysqli_query($mysqli,"select * from pegawai where id_pegawai=$pa[0]");
$peg=mysqli_fetch_array($qpeg);

$qs=mysqli_query($mysqli,"select tgl_sk from sk where id_kategori_sk=5 and id_pegawai=$peg[0] order by tgl_sk desc");
$sk=mysqli_fetch_array($qs);
$tgl=substr($sk[0],8,2);
$bln=substr($sk[0],5,2);
$thn=substr($sk[0],0,4);
echo("

 <tr>
    <td>$i</td>
    <td nowrap=nowrap>$peg[1]</td>
    <td>$peg[nip_baru]</td>
    <td nowrap=nowrap>$data[1]</td>
    <td>$peg[pangkat_gol]</td>
    <td nowrap=nowrap>$tgl-$bln-$thn</td>
  </tr>
");

$i++;
}


  ?>
</table>
</body>
</html>