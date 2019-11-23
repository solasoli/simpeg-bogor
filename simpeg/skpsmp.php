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





?>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td align="center" valign="bottom" colspan="20">Data Pengguna SKP ONLINE 2015</td>
  </tr>
  <tr>
   <?php
   for($i=1;$i<=20;$i++)
{




$qkgb = mysqli_query($mysqli,"select count(*) from skp_header inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=skp_header.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja inner join pegawai on pegawai.id_pegawai=skp_header.id_pegawai where flag_pensiun=0 and nama_baru like 'SMPN $i %' and periode_awal like '2015%' and unit_kerja.tahun=2015 order by unit_kerja.id_unit_kerja");
$kgb = mysqli_fetch_array($qkgb);



   
   ?>
   <td align="center" valign="bottom"><?php echo $kgb[0]; ?><br /><img src="./images/bar.png" width="30" height="<?php echo $kgb[0]; ?>" /></td>
   <?php
   }
   ?>
  </tr>
  <tr>
  <?php   for($i=1;$i<=20;$i++)
{?>
  <td  align="center" valign="top">
<?php echo("SMPN $i");
?> </td>
<?php }
?>
  </tr>
</table>
<p>&nbsp;</p>
<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td align="center" valign="bottom"  colspan="20">Data Pengguna SKP ONLINE 2016</td>
  </tr>
  <tr>
    <?php
   for($i=1;$i<=20;$i++)
{




$qkgb = mysqli_query($mysqli,"select count(*) from skp_header inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=skp_header.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja inner join pegawai on pegawai.id_pegawai=skp_header.id_pegawai where flag_pensiun=0 and nama_baru like 'SMPN $i %' and periode_awal like '2016%' and unit_kerja.tahun=2015 order by unit_kerja.id_unit_kerja");
$kgb = mysqli_fetch_array($qkgb);



   
   ?>
    <td align="center" valign="bottom"><?php echo $kgb[0]; ?><br /><img src="./images/bar.png" alt="s" width="30" height="<?php echo $kgb[0]; ?>" /></td>
    <?php
   }
   ?>
  </tr>
  <tr>
  <?php   for($i=1;$i<=20;$i++)
{ ?>
    <td  align="center" valign="top">
    <?php 
echo("SMPN $i");
?></td>
    <?php }
?>
  </tr>
</table>
<p>&nbsp;</p>

</body>
</html>
