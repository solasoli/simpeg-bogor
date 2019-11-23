<?php
extract($_POST);
session_start();
$childComment = true;

require_once("../../konek.php");
include_once("commentLib.php");

$q = "SELECT * FROM post 
		INNER JOIN pegawai WHERE (pegawai.id_pegawai=post.id_pegawai)
		AND (parent_id = $parentID)
		ORDER BY kapan ASC";

$result = mysqli_query($mysqli,$q);

require_once("commentsView.php");

?>