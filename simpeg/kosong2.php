<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
.kampret {color: #FFFFFF}
body {
	background-color: #FFFFFF;
}
-->
</style></head>

<body>
<?
include("konek.php");

/*
$q=mysqli_query($mysqli,"SELECT jabatan.jabatan, pegawai.id_j,id_unit_kerja,jabatan.id_j
FROM jabatan
LEFT JOIN pegawai ON pegawai.id_j = jabatan.id_j
WHERE pegawai.id_j IS NULL"); // and pegawai.id_next=0 ");
*/

$q=mysqli_query($mysqli,"

SELECT  j.namajabatan, j.idjabatan,j.id_unit_kerja FROM
  (SELECT jabatan.id_j AS idJabatan, jabatan.jabatan AS namaJabatan,id_unit_kerja FROM jabatan
  LEFT JOIN pegawai ON jabatan.id_j = pegawai.id_j
  WHERE pegawai.id_j IS NULL) AS J
LEFT JOIN Pegawai P
ON J.idJabatan = P.id_next
WHERE id_next IS NULL
ORDER BY namaJabatan;");

?>
<table width="500" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666" bgcolor="#999999">
  <tr>
    <td><table width="650" border="0" align="center" cellpadding="5" cellspacing="1">
      
      <tr>
        <td bgcolor="#666666"><div align="center" class="kampret">NO</div></td>
        <td nowrap="nowrap" bgcolor="#666666"><span class="kampret">Unit Kerja </span></td>
        <td nowrap="nowrap" bgcolor="#666666"><span class="kampret">Jabatan Kosong </span></td>
      </tr>
      <?
  $i=1;
  while($data=mysqli_fetch_array($q))
{
/*$qcek=mysqli_query($mysqli,"select count(*) from pegawai where id_next=$data[3]");
$cek=mysqli_fetch_array($qcek);
if($cek[0]==0)
{
*/
$qu=mysqli_query($mysqli,"select nama_baru,id_unit_kerja from unit_kerja where id_unit_kerja=$data[2]");
$unit=mysqli_fetch_array($qu);

if($i%2==0)
echo("<tr bgcolor=#f0f0f0>");
else
echo("<tr  bgcolor=#ffffff >");

echo("
    <td valign=top align=center ><div align=center >$i</div></td>
    <td valign=top align=left><span >$unit[0]</span></td>
    <td valign=top align=left>$data[0]</span></td>
  </tr>");

$i++;

//}

}
  
  ?>
    </table></td>
  </tr>
</table>
</body>
</html>
