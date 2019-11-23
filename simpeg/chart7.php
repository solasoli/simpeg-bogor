<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
body,td,th {
	font-family: tahoma;
	font-size: 12px;
}
.kuya {
	font-size: 500%;
}


-->
</style>
</head>
<body>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" class="table">
<tr>
<td align="center" valign="top">
<?php
$y=$_REQUEST['y'];
echo("<div align=center>");	
include("./php-ofc-library/open_flash_chart_object.php");

	echo("</div>");
?></td>
<td align="left" valign="top">&nbsp;</td>
</tr>
<tr>
  <td align="center" valign="top"><? include("chart3.php");  ?></td>
  <td align="center" valign="middle" style="font-size:larger;">
  <?php
	
	echo("Perkiraan Jumlah Pegawai Tahun ".date('Y')."");
	include("gpensiun.php");
	


?></td>
</tr>

<tr>
  <td colspan="2" align="center" valign="top"><iframe name="kuya" src="fp.php" width="800" frameborder="0" height="800"> </iframe></td>
</tr>
<tr>
  <td colspan="2" align="center" valign="top">

  </td>
</tr>
</table>
</body>
</html>