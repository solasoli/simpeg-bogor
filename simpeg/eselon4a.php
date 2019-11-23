<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body,td,th {
	font-family: tahoma;
	font-size: 12pt;
}
</style>
</head>

<body>
<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from jabatan where eselon='IVB' and Tahun=2011");

?>
<table width="500" border="1" bordercolor="#000000" cellspacing="0" cellpadding="3">
  <tr>
    <td>No</td>
    <td>Nama</td>
    <td>Jabatan</td>
    <td nowrap="nowrap">TMT eselon IVA</td>
  </tr>
  <?
  $i=1;
  while($data=mysqli_fetch_array($q))
  {
	  $qc=mysqli_query($mysqli,"select nama,tmt,sk.id_pegawai from sk inner join pegawai on sk.id_pegawai=pegawai.id_pegawai where sk.id_j=$data[0] and id_kategori_sk=10 order by tmt desc");
	  $cari=mysqli_fetch_array($qc);
	  
	  $qu=mysqli_query($mysqli,"SELECT tmt  FROM `sk` WHERE `id_pegawai` = $cari[2] AND `id_kategori_sk` = 10 order by tmt");
	  $urut=mysqli_fetch_array($qu);
	  echo("<tr>
	  
	  <td>$i</td>
	  <td nowrap>$cari[0]</td>
	   <td nowrap>$data[1]</td>
	   <td>$urut[0]</td>
	  
	  
	  
	  </tr>");
	  
	$i++;  
  }
  
  ?>
</table>
</body>
</html>