<?php
/**
* Initialize the cURL session
*/
$ch = curl_init();
/**
* Set the URL of the page or file to download.
*/
curl_setopt($ch, CURLOPT_URL,'http://simpeg.org/cek.php');

$data='u=480140284&p=t054n';
/**
* Create a new file
*/
$fp = fopen('asik.txt', 'w');
/**
* Ask cURL to write the contents to a file
*/
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
/**
* Execute the cURL session
*/
curl_exec ($ch);
/**
* Close cURL session and file
*/
curl_close ($ch);
fclose($fp);
?>