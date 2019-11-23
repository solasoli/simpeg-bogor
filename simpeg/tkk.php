<?php
mysql_query("insert into tkk (nama,id_unit_kerja) values ('$tkk',$skpd)");
echo("<div align=center> Data Non PNS Sudah ditambahkan </div>");
include("list2_nonpns.php");
?>