<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

include("konek.php");
extract($_GET);
extract($_POST);
if(isset($idm))
{

if($edit!=1)
{
  $sql = "SELECT p.id_j, uk.id_skpd
  FROM pegawai p, current_lokasi_kerja clk, unit_kerja uk
  WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND p.id_pegawai = $idm";
  $q = mysqli_query($mysqli,$sql);
  while($bata=mysqli_fetch_array($q)){
    $id_j = $bata['id_j'];
    $id_skpd = $bata['id_skpd'];
  }
  mysqli_query($mysqli,"insert into nilai_skp (id_pegawai,nilai,tahun,online, id_j, id_skpd) values ($idm,$nilai,2016,0,$id_j,$id_skpd)");
}
else
{
mysqli_query($mysqli,"update nilai_skp set nilai=$nilai where id_pegawai=$idm");

}





echo("<div align=center>SKP Pegawai Sudah disimpan</div>");
include("list2.php");
}
else
{
$qp=mysqli_query($mysqli,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama, nip_baru from pegawai where id_pegawai=$od");
$peg=mysqli_fetch_array($qp);


$qskp=mysqli_query($mysqli,"select nilai from nilai_skp where id_pegawai=$od");
$skp=mysqli_fetch_array($qskp);
?>
<form action="index3.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="80%" border="0" align="center" cellpadding="10" cellspacing="0" class="table">
    <tr>
      <td>Nama
      <input name="idm" type="hidden" id="idm" value="<?php echo $od; ?>" />
      <input name="x" type="hidden" id="x" value="nilaiskp.php" />
      <input name="edit" type="hidden" id="edit" value="<?php echo $edit; ?>" /></td>
      <td>:</td>
      <td><?php echo $peg[0]; ?></td>
    </tr>
    <tr>
      <td>Nip</td>
      <td>:</td>
      <td><?php echo $peg[1]; ?></td>
    </tr>
    <tr>
      <td>Nilai SKP 2016</td>
      <td>:</td>
      <td>

      <label>
      <input name="nilai" type="text" id="nilai" size="10" <?php if($skp[0]!=NULL) echo (" value=$skp[0] "); ?> />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="button" id="button" value="Simpan" />
      </label></td>
    </tr>
  </table>
</form>
<p>
<?php
}
?>
</p>

<p>&nbsp;</p>
</body>
</html>
