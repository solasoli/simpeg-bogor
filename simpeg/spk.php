<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
  <?php
			$qck=mysqli_query($mysqli,"select count(*) from survey_pengkom where id_pegawai=$_SESSION[id_pegawai]");
			$ck=mysqli_fetch_array($qck);
			if($ck[0]==0)
			{
			?>
<form id="form1" name="form1" method="post" action="index3.php#que1">
  <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="center"><a name="que1" id="que1"></a></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><h3>apakah  pegawai membutuhkan program magang sebagai upaya peningkatan kompetensi?</h3></td>
    </tr>
    <tr>
      <td align="center"><input type="radio" name="radio" id="radio" value="ya" />
      <label for="radio">
        <strong>Ya </strong>
        <input type="radio" name="radio" id="radio" value="tidak" />
      <strong>Tidak</strong></label></td>
    </tr>
    <tr>
      <td align="center"><input type="submit" name="button" id="button" value="Simpan" />
      <input name="idp" type="hidden" id="idp" value="<?php echo $_SESSION['id_pegawai']; ?>" />
      <input name="x" type="hidden" id="x" value="spk1.php" /></td>
    </tr>
  </table>
</form>
<?php }
else
echo("<h3>Anda Sudah Mengisi Survey Ini Sebelumnya</h3>");
?>
</body>
</html>