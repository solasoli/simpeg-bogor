<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
#form1 #s {
	text-align: center;
}
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="fb.php">
  <label for="s"></label>
  <select name="s" id="s">
  <?
  extract($_POST);
  include("konek.php");
  $q=mysqli_query($mysqli,"select eselon from jabatan where eselon not like '%walikota%' group by eselon");
  echo("<option value=0> Semua</option> ");
  while($data=mysqli_fetch_array($q))
  {
	  if($s==$data[0])
	 echo("<option value=$data[0] selected> $data[0]</option> ");
	 else
	 	 echo("<option value=$data[0]> $data[0]</option> ");

  }
  ?>
  </select>
  <input type="submit" name="button" id="button" value="Submit" />
</form>
<?
if($s!=NULL)
include("buana.php");
?>
</body>
</html>