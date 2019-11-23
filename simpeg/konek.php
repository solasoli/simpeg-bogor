<?php

	define('BASE_URL', "http://" . $_SERVER['HTTP_HOST'] . "/simpeg/");
	define('HTTP_HOST', "http://" . $_SERVER['HTTP_HOST']);
	//$mysqli = mysqli_connect("simpeg.db.kotabogor.net","root","koplak123!bkpsd4","simpeg");
	$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");

	//$mysqli = new mysqli("103.14.229.28","root","koplak123!bkpsd4","simpeg");

?>
