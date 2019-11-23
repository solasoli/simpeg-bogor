<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Untitled Document</title>

<style type="text/css">

<!--

body,td,th {

	font-family: Arial, Helvetica, sans-serif;

	font-size: 12px;

	color: #000000;

}

-->

</style></head>



<body>

<p>

  <?

include("konek.php");





?>

</p>

<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#000000">

  <tr>

    <td>no</td>

    <td>nama</td>

    <td>jabatan</td>

    <td>unit kerja </td>

    <td>pangkat golongan </td>

    <td>tingkat pendidikan </td>

    <td>lembaga</td>

  </tr>

 

 <? $q=mysqli_query($mysqli,"SELECT pegawai.id_pegawai,nama,pegawai.jabatan,pangkat_gol,nama_baru from pegawai inner join jabatan on pegawai.jabatan=jabatan.jabatan inner join unit_kerja on jabatan.id_unit_kerja=unit_kerja.id_unit_kerja where flag_pensiun=0 order by nama_baru ");

 $i=1;

while($data=mysqli_fetch_array($q))

{

$q2=mysqli_query($mysqli,"select tingkat_pendidikan,lembaga_pendidikan from pendidikan where id_pegawai=$data[0] order by tahun_lulus desc");

$dat=mysqli_fetch_array($q2);



echo("<tr>

    <td>$i</td>

    <td>$data[1]</td>

    <td>$data[2]</td>

    <td>$data[4]</td>

    <td>$data[3]</td>

    <td>$dat[0]</td>

    <td>$dat[1]</td>

  </tr>");

$i++;

}

  

  ?>

  

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

</table>

<p>&nbsp;</p>

</body>

</html>

