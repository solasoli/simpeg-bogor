<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
-->
</style></head>

<body>
<?
include("konek.php");
$q=mysqli_query($mysqli,"SELECT id_skpd FROM unit_kerja where tahun=2011 and id_skpd>0 and id_skpd<>4086  group by id_skpd");

?>
<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td>No</td>
    <td>SKPD</td>
    <td>Struktural</td>
    <td>Fungsional</td>
    <td>Jumlah</td>
  </tr>
  <?
  $sub=0;
  $i=1;
  $s1=0;
  $s2=0;
  while($data=mysqli_fetch_array($q))
  {
  $q2=mysqli_query($mysqli,"select count(*) from pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=pegawai.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where tgl_pensiun_dini>'2012-01-01' and jenjab not like '%fungsional%' and id_skpd=$data[0]");
  $q3=mysqli_query($mysqli,"select count(*) from pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=pegawai.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where tgl_pensiun_dini>'2012-01-01' and jenjab  like '%fungsional%' and id_skpd=$data[0]");
  $struk=mysqli_fetch_array($q2);
  $fung=mysqli_fetch_array($q3);
 $q4=mysqli_query($mysqli,"select nama_baru from unit_kerja where id_unit_kerja=$data[0]");
  $nama=mysqli_fetch_array($q4);
  
  if($nama[0]=="Dinas Kebersihan Dan Pertamanan")
  $struk[0]=$struk[0]+4;
  
  $tot=$struk[0]+$fung[0];
  
  
echo("<tr>
    <td>$i</td>
    <td>$nama[0] </td>
    <td>$struk[0]</td>
    <td>$fung[0]</td>
    <td>$tot</td>
  </tr>
");
$s1=$s1+$struk[0];
$s2=$s2+$fung[0];
$sub=$sub+$tot;
$i++;
}
  
  ?>
  <tr>
    <td></td>
    <td>Jumlah:</td>
    <td><? echo($s1); ?></td>
    <td><? echo($s2); ?></td>
    <td><? echo($sub); ?></td>
  </tr>

</table>
</body>
</html>
