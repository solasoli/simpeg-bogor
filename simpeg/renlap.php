<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?
include("konek.php");
$q=mysqli_query($mysqli,"SELECT *
FROM `jabatan`
WHERE `jabatan` LIKE '%dan Pelaporan%'
AND `Tahun` =2011");



?>
<table width="500" border="1" bordercolor="#000000" cellspacing="0" cellpadding="3">
  <tr>
    <td>NO</td>
    <td>Nama</td>
    <td>NIP Lama</td>
    <td>NIP Baru</td>
    <td>Jabatan</td>
    <td>Telepon</td>
  </tr>
  <?
  $i=1;
  while($data=mysqli_fetch_array($q))
  {
	  $q1=mysqli_query($mysqli,"select nama,nip_baru,nip_lama,ponsel from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where sk.id_j=$data[0] and id_kategori_sk=10 order by tmt desc");
	  $ata=mysqli_fetch_array($q1);
	echo(" <tr>
    <td>$i</td>
    <td nowrap>$ata[0]</td>
    <td  nowrap>$ata[1]</td>
    <td nowrap>$ata[2]</td>
    <td nowrap>$data[1]</td>
    <td nowrap>$ata[3]</td>
  </tr>");  
	$i++;  
  }
  
  ?>
</table>
</body>
</html>