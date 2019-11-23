<?php
include("konek.php");
$q=mysql_query("show columns from jfu_pegawai");
while($data=mysql_fetch_array($q))
echo("$data[0]<br>");
?>