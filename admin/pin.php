<?php
	session_start();
	if($_POST['pin'] == 'gandalf'){	
		$_SESSION['pin'] = 'gandalf';
		header("location:index2.php");
	}
?>

<form method="post">
<input type="password" name="pin" placeholder="Enter PIN" />
<input type="submit" value="Enter" />
</form>