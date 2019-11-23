<?php
extract($_POST);
require_once("../../konek.php");
include_once("commentLib.php");

$q = "SELECT * FROM post 
		INNER JOIN pegawai WHERE (pegawai.id_pegawai=post.id_pegawai)
		AND (parent_id IS NULL OR  parent_id = 0)
		ORDER BY kapan DESC LIMIT 0,1";

$result = mysql_query($q);

require_once("commentsView.php");

?>