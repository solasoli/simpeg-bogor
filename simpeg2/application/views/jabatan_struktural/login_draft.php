<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div class="container">
<form id="form1" name="form1" method="post" action="<?php echo base_url()."jabatan_struktural/login_draft"; ?>">
 <h3> Password Draft Pelantikan</h3>

  <input type="password" name="kunci" id="kunci" />
  <input type="submit" name="login" id="login" value="Login" />
  <input name="idd" type="hidden" id="idd" value="<?php echo($idd); ?>" />
 <span style="color:red; font-weight: bold"><?php echo($pwdsalah); ?></span>
</form>
 </div>
</body>
</html>