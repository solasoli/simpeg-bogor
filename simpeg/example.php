<?php
$ourFileName = "cookies.txt";
$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
fclose($ourFileHandle);

include_once("Kalkun_API.php");

$config['base_url'] = "http://localhost/kalkun/index.php/";
$config['session_file'] = "cookies.txt";
$config['username'] = "kalkun";
$config['password'] = "kalkun";
$config['phone_number'] = "0816636730";
$config['message'] = "Test tosan";

$sms = new Kalkun_API($config);
$sms->run();
/*
$config['phone_number'] = "081318866519";
$sms2 = new Kalkun_API($config);
$sms2->run();
*/

?>