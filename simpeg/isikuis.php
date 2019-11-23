<?php
extract($_GET);
extract($_POST);
mysql_query("update pegawai set os='$os',ponsel='$hp' where id_pegawai=$_SESSION[id_pegawai]");
echo("<div align=center><h4> Terima Kasih Telah Berpartisipasi Dalam Melengkapi Data SIMPEG anda </h4> </div>");

?>
