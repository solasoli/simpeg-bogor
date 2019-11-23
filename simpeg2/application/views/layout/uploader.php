<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo site_url()."pegawai/uploadpoto"; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <label>
  <input type="file" name="poto" id="poto" />
  </label>
  <label>
  <input type="submit" name="button" id="button" value="upload" />
  </label>
  <input name="idp" type="hidden" id="idp" value="<?php echo $idp; ?>" />
  <input name="keyword" type="hidden" id="keyword" value="<?php echo $keyword; ?>" />
</form>
</body>
</html>
