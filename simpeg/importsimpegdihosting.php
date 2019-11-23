<?php
// langkah8 disimpan di hosting untuk menjadikan simpeg.sql masuk kedalam database php my admin hosting
include "konek5.php";
/*$dbName ='simpeg';
$dbUser='k0230277';
$dbPass='51mp36';
$myfile = "./public_html/backupsimpegdariserver" ;*/
$myfile="./backupsimpegdariserver";     
$command = "\"C:\\xampp\MySQL\bin\mysql\" -u ".$dbUser." -p".$dbPass." ".$dbName."  < \"".$myfile."\\".$dbName.".sql\"";//pathnya masih salah yang ada di hosting perintah sqlnya ditaro dmna?

echo "$command";

// perintah untuk menjalankan perintah mysqldump dalam shell melalui PHP
exec($command);

exit;
?>
