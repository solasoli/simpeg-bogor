<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="fp.php">
  <p align="center"><label for="thn">Tahun</label>
  <select name="thn" id="thn">
  <?
  $thn=date("Y");
extract($_POST);
extract($_GET);
  for($y=2011;$y<=2014;$y++)
  {
	  if($thn==$y)
  echo("<option value=$y selected> $y </option>");
  else
echo("<option value=$y > $y </option>");
  
  
  }
  ?>
  </select>
  <input type="submit" name="button" id="button" value="Submit" />
  </p>
</form>
<?
if($thn!=NULL);
include("pension.php");

?>
</body>
</html>