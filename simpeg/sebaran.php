<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 11px;
}
</style>
</head>

<body>
<?php
include("konek.php");
$q=mysqli_query($mysqli,"select concat(gelar_depan,' ',nama,' ',gelar_belakang),nip_baru,tingkat_pendidikan,jurusan_pendidikan,id_j,jenjab,pegawai.id_pegawai,jabatan from pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=pegawai.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja inner join pendidikan_terakhir on pendidikan_terakhir.id_pegawai=pegawai.id_pegawai where flag_pensiun=0 and id_skpd=4199 order by id_j desc,pangkat_gol");
?>
<div align="center">
  <h1>Badan Pelayanan Perizinan Terpadu dan Penanaman Modal</h1></div><table width="90%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#000000">
  <tr>
    <td>No</td>
    <td>Nama</td>
    <td>NIP</td>
    <td>Pendidikan</td>
    <td>Jabatan</td>
  </tr>
  <?php
  $i=1;
  while($data=mysqli_fetch_array($q))
  {
	  if($data[4]==NULL)
	  {
		if($data[2]=='Struktural')
		{$qj=mysqli_query($mysqli,"select nama_jfu from jfu_pegawai inner join jfu_master on jfu_pegawai.kode_jabatan=jfu_master.kode_jabatan where id_pegawai=$data[6]");  
		$jab=mysqli_fetch_aray($qj);
		}
		  else
		{$jab[0]=$data[7];
		}
	  }
	  else
	  {
	  $qj=mysqli_query($mysqli,"select jabatan from jabatan where id_j=$data[4]");
	  $jab=mysqli_fetch_array($qj);
	  }
	  echo("<tr>
    <td>$i</td>
    <td>$data[0]</td>
    <td>$data[1]</td>
    <td>$data[2] $data[3]</td>
    <td>$jab[0]</td>
  </tr>");
  $i++;
	  
  }
  ?>
</table>
</body>
</html>