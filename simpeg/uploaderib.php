<?php
session_start();
extract($_GET);
$_SESSION['katberkas']=$idkat;
$_SESSION['idpegawai']=$idp;
$_SESSION['nmberkas']=$nm_berkas;
$_SESSION['inisial_berkas']=$inisial_berkas;
$_SESSION['idib']=$idib;

//echo $_SESSION['katberkas'].'-'.$_SESSION['idpegawai'].'-'.$_SESSION['nmberkas'].'-'.$_SESSION['inisial_berkas'].'-'.$_SESSION['idib'];

$_SESSION['reupload']=$upload_ulang;
$_SESSION['idberkas']=$id_berkas;

//echo $_SESSION['reupload'].'-'.$_SESSION['idberkas'];

error_reporting(E_ALL | E_STRICT);
require('UploadHandlerib.php');
$upload_handler = new UploadHandler();
