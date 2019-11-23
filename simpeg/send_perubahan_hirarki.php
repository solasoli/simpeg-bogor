<?php
include "konek.php";

mysql_query("INSERT INTO admin_inbox (id_pegawai, pesan, tanggal)
			 VALUES($_POST[id], 'Melaporkan perubahan hirarki pegawai', CURDATE())");
			 
			 echo "INSERT INTO admin_inbox (id_pegawai, pesan, tanggal)
			 VALUES($_POST[id], 'Melaporkan perubahan hirarki pegawai', CURDATE())";
?>