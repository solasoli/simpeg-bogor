<?php
session_start();
extract($_GET);
$_SESSION['katberkas']=$idkat;
$_SESSION['idpegawai']=$idp;
$_SESSION['nmberkas']=$nm_berkas;

$_SESSION['reupload']=$upload_ulang;
$_SESSION['idberkas']=$id_berkas;

//echo $_SESSION['reupload'].'-'.$_SESSION['idberkas'];

error_reporting(E_ALL | E_STRICT);
require('UploadHandlerkp.php');
$upload_handler = new UploadHandler();
