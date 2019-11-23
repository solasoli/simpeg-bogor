<?php
include "konek.php";

$mysqli->query("CALL PRC_REPORT_DUK();");

echo "done";
?>