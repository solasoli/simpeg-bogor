<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style></head>

<body>
<?php
include("konek.php");
extract($_POST);


?>
<form id="form1" name="form1" method="post" action="anjab_pegawai.php">
  Unit Kerja 
  <select name="skpd" id="skpd" >
  <?php
  $qunit=mysqli_query($mysqli,"select id_unit_kerja,nama_baru from unit_kerja where tahun=2017");
  while($data=mysqli_fetch_array($qunit))
  {
  echo("<option value=$data[0]> $data[1] </option>");
  
  }
  ?>
    
  </select>
  <input type="submit" name="button" id="button" value="Submit" />
  </form>
<?php

if(isset($skpd))
{

?>

<form id="form2" name="form2" method="post" action="insert_anjabp.php">
<table border="0" cellpadding="5" cellspacing="0">
<tr>
<td> Nama</td><td>: </td><td> Nama JFU</td>

</tr>
<?php
$qp=mysqli_query($mysqli,"select nama,pegawai.id_pegawai from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where id_unit_kerja=$skpd and flag_pensiun=0 and id_j is null and jenjab like 'struktural'");
$i=1;
while($p=mysqli_fetch_array($qp))
{
?>
<tr>
<td> <?php echo $p[0] ?></td><td>: </td><td> <input type="hidden" name="idp<?php echo $i ?>" id="idp<?php echo $i ?>" value="<?php echo $p[1]; ?>" />
<select name="jfu<?php echo $i ?>" id="jfu<?php echo $i ?>">
<option value="0">Pilih jabatan </option>
<?php
$q=mysqli_query($mysqli,"select anjab_master.id,nama_jfu from anjab_uraian inner join anjab_master on anjab_master.id=anjab_uraian.id_anjab inner join jfu_master on jfu_master.id_jfu=anjab_master.id_jfu where id_skpd=$skpd group by nama_jfu ");
while($ata=mysqli_fetch_array($q))
echo("<option value=$ata[0]> $ata[1] </option>");

?>
</select>
<label>

</label>

</td>

</tr>

<?php
$i++;
}
$total=$i-1;
?>
<input type="hidden" name="total" id="total" value="<?php echo $total; ?>" />
</table>
  <input type="submit" name="button" id="button" value="Submit" />
</form>
<?php
}
?>
</body>
</html>
