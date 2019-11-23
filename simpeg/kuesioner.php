<html>
<head>
</head>
<body>
<?php

$qp=mysqli_query($mysqli,"select ponsel,os from pegawai where id_pegawai=$_SESSION[id_pegawai]");
$pon=mysqli_fetch_array($qp);

?>
<form name="form1" id="form1" method="post" action="index3.php">
<table width="70%" align="center" >
<tr><td colspan="3" align="Center"> <h3>Kuesioner SIMPEG</h3></TD> </tr>
<tr><td colspan="3">&nbsp; </TD> </tr>
<tr >
<td style="padding:10px !important;">No Handphone</td>
<td>:</td>
<td>&nbsp;&nbsp;&nbsp;<input type="text" name="hp" id="hp" 
<?php if(strlen($pon[0])>4) echo " value='$pon[0]' "; ?> 
> * Silakan Ubah Jika Tidak Sesuai</td>
</tr>
<tr>
<td style="padding:10px !important;" align="left" valign="top">Sistem Operasi</td>
<td align="left" valign="top" style="padding:10px !important;" >:</td>
<td align="left" valign="top" style="padding:10px !important;" valign="bottom" ><input type="radio" name="os" value="Android"
<?php if($pon[1]=="Android" ) echo " checked=cheked "; ?>
> &nbsp;&nbsp;&nbsp;<img src="./images/andro.png" width="20" style="vertical-align: baseline;" /> &nbsp;&nbsp;&nbsp;Android <br>
<input type="radio" name="os" value="Ios" <?php if($pon[1]=="Ios" ) echo " checked=cheked "; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<img src="./images/apple.gif" width="20" style="vertical-align: baseline;" /> &nbsp;&nbsp;&nbsp;Apple <br>
<input type="radio" name="os" value="BB" <?php if($pon[1]=="BB" ) echo " checked=cheked "; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<img src="./images/bb.png" width="20" style="vertical-align: baseline;" /> &nbsp;&nbsp;&nbsp;Black Berry <br>
<input type="radio" name="os" value="Lainnya" <?php if($pon[1]=="Lainnya" ) echo " checked=cheked "; ?> >&nbsp;&nbsp;&nbsp;&nbsp;Lainnya<br>

</td>
</tr>
<tr>
<td >
<input type="hidden" name="x" id="x" value="isikuis.php">
<td >
<td >
<input type="submit" value="Simpan" >
</td>
</tr>






</table>





</form>
</body>
</html>