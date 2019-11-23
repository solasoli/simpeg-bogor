<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?
$chat=$_REQUEST['chat'];
$gw=$_REQUEST['gw'];
include("konek.php");
echo($kuya);

?>
<script src="jquery-1.4.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
.lwbar {
	position:absolute;
	width: 600;
}
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <label for="textarea"></label>
  <label for="textfield"></label>
  <input type="text" name="textfield" id="textfield" />
</form>
</body>
</html>