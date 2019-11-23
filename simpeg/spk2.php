<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<p>
  <?php
extract($_POST);
if(@$radio!=NULL or @$radio2!=NULL or @$lainnya!=NULL)
{
	  if(@$radio!=NULL)
	mysqli_query($mysqli,"update survey_pengkom set jenis_kompetensi_teknis='$radio' where id_pegawai=$idp");
	elseif(@$lainnya!=NULL)
	mysqli_query($mysqli,"update survey_pengkom set jenis_kompetensi_teknis='$lainnya' where id_pegawai=$idp");
	
	if(@$radio2!=NULL)
	mysqli_query($mysqli,"update survey_pengkom set tempat_magang_manajerial='$radio2' where id_pegawai=$idp");
	
}
else
{
mysqli_query($mysqli,"update survey_pengkom set alasan_gabut='$alasan' where id_pegawai=$idp");	
	
}
?>
  
  <a name="que1" id="que1"></a></p>
<p>&nbsp;</p>
<p>
  <?php
echo("<div align=center>Terima kasih sudah berpartisipasi dalam survey ini </div>");

?>
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p><p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>