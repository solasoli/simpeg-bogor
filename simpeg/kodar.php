<html>

<head>

</head>

<body>



<?

include("konek.php");

$q=mysqli_query($mysqli,"SELECT pendidikan.id_pegawai,nama,pegawai.id_pegawai,nip_baru

FROM `pegawai`

left JOIN pendidikan ON pegawai.id_pegawai = pendidikan.id_pegawai

WHERE flag_pensiun =0 and pendidikan.id_pegawai is NULL 

");





?>

<table width="400" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">

  <tr>

    <td><div align="center">nama</div></td>

    <td><div align="center">unit kerja </div></td>

	<td><div align="center">nip baru</div></td>

  </tr>

  <?

  while($data=mysqli_fetch_array($q))

{



$qu=mysqli_query($mysqli,"select nama_baru from riwayat_mutasi_kerja inner join unit_kerja on  riwayat_mutasi_kerja.id_unit_kerja= unit_kerja.id_unit_kerja where id_pegawai=$data[2] order by id_riwayat desc");





$unit=mysqli_fetch_array($qu);

echo("  <tr>

    <td>$data[1]</td>

    <td>$unit[0] </td>

	 <td>$data[3]&nbsp; </td>

  </tr>

");



}

  

  

  ?>

</table>

</body>

</html>