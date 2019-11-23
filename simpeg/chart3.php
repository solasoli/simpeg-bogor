<form id="form1" name="form1" method="post" action="">
</form>
<?php
//include("./php-ofc-library/open_flash_chart_object.php");
open_flash_chart_object( 350, 250,"http://". $_SERVER['SERVER_NAME'] ."/simpeg/grafik69.php?id=$ata[0]",false);
?>