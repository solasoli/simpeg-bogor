<?php
require_once("../../konek.php");

extract($_POST);

mysql_query("DELETE FROM post WHERE parent_id = $id_post");
mysql_query("DELETE FROM post WHERE id_post = $id_post");

?>