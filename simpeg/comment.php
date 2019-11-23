<?php	
	session_start();
?>
<script type="text/javascript" src="cunda/comment/commentLib.js">
</script>
<link rel="stylesheet" type="text/css" href="cunda/comment/post.css" />

<?php
	require_once("cunda/comment/commentLib.php");
		
	if($_SESSION['user'])
	{
		$q = "SELECT * FROM post 
				INNER JOIN pegawai ON pegawai.id_pegawai = post.id_pegawai
				WHERE id_post = $_REQUEST[id_post]";
		$result = mysql_query($q);
		$r = mysql_fetch_array($result);
		include("cunda/comment/commentView.php");
	}
	else
	{
		header('location:index.php');
	}
?>