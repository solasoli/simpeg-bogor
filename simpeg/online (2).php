<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Untitled Document</title>

<style type="text/css">

<!--

body,td,th {

	font-family: Tahoma;

	font-size: 11px;

}

-->

</style></head>



<body>

<table width="200" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td align="left" valign="top"><table border="0" cellpadding="3" cellspacing="0" >

      <tr >

        <td nowrap="nowrap"> golongan :

          <?

include("konek.php");

$id=$_REQUEST['id'];

$y=$_REQUEST['y'];

//echo("isinya $id");

 echo($y); ?></td>

        <td>&nbsp;</td>

      </tr>

      <?

$sql = "SELECT nama_baru,riwayat_mutasi_kerja.id_unit_kerja from riwayat_mutasi_kerja inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja

				=unit_kerja.id_unit_kerja where id_pegawai=$id order by id_riwayat desc";

				

				$result = mysqli_query($mysqli,$sql);

				$r = mysqli_fetch_array($result);

				$unit = $r[1];



$qavg=mysqli_query($mysqli,"select distinct(pangkat_gol) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$unit   order by pangkat_gol");

while($avg=mysqli_fetch_array($qavg))

echo("<tr><td align=center><a href=sim.php?id=$id&&y=$avg[0]>$avg[0]</a></td></tr>");



?>

      <tr>

        <td colspan="18"></td>

      </tr>

    </table></td>

    <td align="left" valign="top"><?

$y=$_REQUEST['y'];

if($y!=NULL)

{



$qavg2=mysqli_query($mysqli,"select nama from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$unit and pangkat_gol='$y' and flag_pensiun=0  order by nama");

echo("<table cellspacing=0 cellpadding=3 border=0 ><tr bgcolor=#f0f0f0><td> No </td><td> Nama </td></tr>");

$an=1;

while($vg=mysqli_fetch_array($qavg2))

{

if($an%2==1)

echo("<tr>");

else

echo("<tr bgcolor=#f0f0f0>");



echo("<td>$an</a><td nowrap>$vg[0]</td></tr>");

$an++;

}

echo("</table>");





}





?></td>

  </tr>

</table>

</td>

<td align="left" valign="top">



</body>

</html>

