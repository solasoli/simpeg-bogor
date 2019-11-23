<?php
// membaca file koneksi.php
include "konek.php";
$dbName ='simpeg';
$dbUser='simpeg_root';
$dbPass='51mp36';
$myfile = "C:\\xampp\htdocs\simpeg\backupsimpegdariserver" ;       
$command = "\"C:\\xampp\MySQL\bin\mysqldump\" -u ".$dbUser." -p".$dbPass." ".$dbName."  > \"".$myfile."\\".$dbName.".sql\"";
// perintah untuk menjalankan perintah mysqldump dalam shell melalui PHP

exec($command);


/* kompresi file dump */
//$filezip = $myfile ."\\". $dbName . ".zip";
//$file = $myfile ."\\". $dbName . ".sql";
$filezip="C:\\xampp\htdocs\simpeg\backupsimpegdariserver\simpeg.zip" ;
$file="C:\\xampp\htdocs\simpeg\backupsimpegdariserver\simpeg.sql" ;
$zip-> new ZipArchive();
echo $zip;
if(($zip->open('$filezip', ZipArchive::CREATE))!==true){ die('Error: Unable to create zip file');}
$zip->addFile($file);
$zip->close();
exit;


?>

