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
$filedump ="backupsimpegdariserver/$dbName.sql";
$filezip = "backupsimpegdariserver/$dbName.zip";
$zip = new ZipArchive();
if(($zip->open($filezip, ZIPARCHIVE::CREATE))!==true){ die('Error: Unable to create zip file');}
$zip->addFile($filedump);
$zip->close();
exit;
 

//if (file_exists($filezip)) unlink($filezip);
//$aksi = "zip -j $filezip $filedump";
//echo $aksi;
//exec($aksi);
//if ($c != 0) {
    //$kalimatkonfirmasi = "Proses kompresi file dump gagal";
    //die();	
//}
//exit;
?>
