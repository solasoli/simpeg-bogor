
<style type="text/css">
<!--
.anjang {
	width: 335px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
.leutik {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
-->
</style>

<form id="form1" name="form1" method="post" action="chart4.php">
  <label>
  <div align="center">
    <select name="idu" class="anjang" id="idu" >
      <?
	  
	  include("konek.php"); 
$idu=$_REQUEST['idu'];
$thn=date("Y");
$q=mysqli_query($mysqli,"select id_skpd from unit_kerja where tahun=$thn group by id_skpd");


while($data=mysqli_fetch_array($q))
{
$q1=mysqli_query($mysqli,"select nama_baru from unit_kerja where id_unit_kerja=$data[0]");	
	$dat=mysqli_fetch_array($q1);
	if($idu==$data[0])
	echo("<option value=$data[0] selected>$dat[0]</option>");
	else
	echo("<option value=$data[0]>$dat[0]</option>");
}
  ?>
      
    </select>
    <input name="Submit" type="submit" class="leutik" value="Lihat !" />
  </div>
  </label>
  <label></label>
</form>
<? //echo("select id_skpd from unit_kerja where tahun=$thn group by id_skpd"); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle"><?php
include("./php-ofc-library/open_flash_chart_object.php");
open_flash_chart_object( 335, 320,"http://". $_SERVER['SERVER_NAME'] ."/simpeg/grafik70.php?idu=$idu",false);
?></td>
  </tr>
</table>