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

	color: #737373;

}

-->

</style></head>

<?php

$s=$_REQUEST['s'];

include("konek.php");

$q=mysqli_query($mysqli,"select nama,nama_baru,pegawai.id_pegawai,nip_lama,nip_baru,tgl_lahir from pegawai inner join riwayat_mutasi_kerja on pegawai.id_pegawai=riwayat_mutasi_kerja.id_pegawai inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where nama like '%$s%' or nama_baru like '%$s%' group by id_pegawai,nip_lama,nip_baru  order by nama ");

?>

<body>

<div align="center" id="txtHint" >

<table width="200" border="0" align="center" cellpadding="5" cellspacing="0">

  <tr>

    <td nowrap="nowrap" bgcolor="#f0f0f0"><div align="center">Nama</div></td>

	<td nowrap="nowrap" bgcolor="#f0f0f0"><div align="center">Tgl Lahir</div></td>

	<td nowrap="nowrap" bgcolor="#f0f0f0"><div align="center">NIP</div></td>

<td nowrap="nowrap" bgcolor="#f0f0f0"><div align="center">NIP Baru</div></td>

    <td bgcolor="#f0f0f0"><div align="center">Unit Kerja </div></td>

  </tr>

  <?

  $i=1;

while($data=mysqli_fetch_array($q))

{



$k=mysqli_query($mysqli,"select nama_baru from riwayat_mutasi_kerja inner join pegawai on riwayat_mutasi_kerja.id_pegawai=pegawai.id_pegawai inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where riwayat_mutasi_kerja.id_pegawai=$data[2] order by id_riwayat desc");

				

				$unit=mysqli_fetch_array($k);

	

	if($i%2==0)

	echo("<tr bgcolor=#f0f0f0>");

	else

	echo("<tr >");

	

	if($data[3]=='-')

	$nip=$data[4];

	else

	$nip=$data[3];

	

$tgl=substr($data[5],8,2);

$bln=substr($data[5],5,2);

$thn=substr($data[5],0,4);

if($unit[0]==$data[1])

	echo("<td nowrap><a href=index2.php?x=home3.php&&id=$data[2]&&s=$s>$data[0]</a></td>

<td nowrap>$tgl/$bln/$thn </td>



	 <td nowrap>$nip </td>

<td nowrap>$data[4] </td>

    <td nowrap>$unit[0] </td>

  </tr>");

				

$i++;

}





?>

</table>

</div>

</body>

</html>

