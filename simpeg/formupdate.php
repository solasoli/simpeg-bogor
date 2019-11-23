<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body,td,th {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 11px;
}
</style>
</head>

<body>
<?
include("konek.php");
extract($_GET);
$q=mysqli_query($mysqli,"select nama,telepon,ponsel,email from pegawai where id_pegawai=$id");
$data=mysqli_fetch_array($q);
?>
<form id="form1" name="form1" method="post" action="updatep.php">
  <table width="400" border="0" align="center" cellpadding="3" cellspacing="0">
    <tr>
      <td>Nama
      <input name="id" type="hidden" id="id" value="<? echo($id);  ?>" />
      <input name="u" type="hidden" id="u" value="<? echo($u);  ?>" /></td>
      <td>:</td>
      <td><? echo("$data[0]"); ?></td>
    </tr>
    <tr>
      <td>Telepon</td>
      <td>:</td>
      <td><input name="t" type="text" id="t" value="<? echo("$data[1]"); ?>" /></td>
    </tr>
    <tr>
      <td>Ponsel</td>
      <td>:</td>
      <td><input name="p" type="text" id="p" value="<? echo("$data[2]"); ?>" /></td>
    </tr>
    <tr>
      <td>email</td>
      <td>:</td>
      <td><input name="email" type="text" id="email" value="<? echo("$data[3]"); ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Simpan" /></td>
    </tr>
  </table>
</form>
</body>
</html>