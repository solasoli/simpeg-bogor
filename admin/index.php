<?php
session_start();
include("koncil.php");

require './library/format.php';

require './pegawai.php';


$obj_pegawai = new Pegawai();


if($_POST){

	$obj_pegawai->nip = $_POST['u'];
	$obj_pegawai->password = $_POST['p'];
	

	if($obj_pegawai->login_admin()){

		$pegawai = $obj_pegawai->get_by_nip($_POST['u']);
		$_SESSION['user'] = $pegawai->nip_baru;
		$_SESSION['nama'] = $pegawai->nama;
		$_SESSION['id_pegawai'] = $pegawai->id_pegawai;
		header('location:index2.php');
	}else{
		echo("<div align=center class='error'>username atau password salah, atau anda tidak memiliki kewenangan </div><br>");
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Administrator SIMPEG KOTA BOGOR</title>

<link href="login-box.css" rel="stylesheet" type="text/css" />
</head>

<body>


<div style="align: center;">


<div id="login-box">

<H2>Login Admin SIMPEG BKPP</H2>
<br />
<br />
<form action="index.php" method="post" name="form1" id="form1" />
<div id="login-box-name" style="margin-top:20px;">NIP:</div>
<div id="login-box-field" style="margin-top:20px;">
	<input name="u" id="u" class="form-login" title="Username" value="" size="30" maxlength="2048" />
</div>
<div id="login-box-name">Password:</div>
<div id="login-box-field">
	<input name="p" id="p" type="password" class="form-login" title="Password" value="" size="30" maxlength="2048" /></div>
<br />
<br />
<br />
<a href="#"><input type="image"  src="images/login-btn.png" width="103" height="42" style="margin-left:90px;" /></a>

</form>




</div>

</div>













</body>
</html>
