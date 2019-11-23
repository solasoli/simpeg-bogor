<?php
session_start();
extract($_GET);
$_SESSION['kode']=$idkat;
$_SESSION['pbel']=$idp;
$_SESSION['tingkat']=$tp;
error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');
$upload_handler = new UploadHandler();
