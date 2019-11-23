<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style><form id="form1" name="form1" method="post" action="form2017.php">
  Bulan:
  <label>
  <select name="bulan" id="bulan">
    <option value="1">Januari</option>
    <option value="2">Februari</option>
    <option value="3">Maret</option>
    <option value="4">April</option>
    <option value="5">Mei</option>
    <option value="6">Juni</option>
    <option value="7">Juli</option>
    <option value="8">Agustus</option>
    <option value="9">September</option>
    <option value="10">Oktober</option>
    <option value="11">November</option>
    <option value="12">Desemeber</option>
  </select>
  </label>
  <label>
  <input type="submit" name="button" id="button" value="tampilkan" />
  </label>
</form>
<?php
mysqli_connect("simpeg.db.kotabogor.net","simpeg", "Madangkara2017");
mysqli_select_db("simpeg");
extract($_POST);
$bul=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
if(isset($bulan))
{
$q=mysqli_query($mysqli,"select count(*),p$bulan from gaji2017 where flag_pensiun=0 and p$bulan!='pensiun' and flag_provinsi=0  group by p$bulan order by p$bulan");


?>
<table width="500" border="1" cellpadding="10" cellspacing="0" bordercolor="#000">

  <tr>
    <td>Bulan</td>
    <td><?php echo $bul[$bulan]; ?></td>
  </tr>
  <?php
$tot=0;
while($data=mysqli_fetch_array($q))
{
?>
  <tr>
    <td><?php echo $data[1] ?></td>
    <td><?php echo $data[0] ?></td>
  </tr>
  <?php
  $tot=$tot+$data[0];
}
?>
<tr>
<td> Total :</td>
<td> <?php echo $tot; ?></td>
</tr>
</table>
  <?php
}
?>