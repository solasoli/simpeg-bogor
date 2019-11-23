<?php
mysqli_query($mysqli,"delete from tkk where id=$id");
echo("<div align=center>Data Non PNS sudah dihapus </div>");
include("list2.php");
?>