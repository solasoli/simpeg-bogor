<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="up.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <label for="fileField"></label>
  <input type="file" name="fileField" id="fileField" />
  <input type="submit" name="button" id="button" value="Submit" />
</form>
<?php
extract($_POST);
if($_FILES['fileField']['size']>0)
echo $_FILES['fileField']['type'];

?>
</body>
</html>