<?php
session_start();
extract($_GET);
$_SESSION['katberkas']=$idkat;
$_SESSION['idpegawai_uploader']=$idp_uploader;
$_SESSION['idpegawai_cutier']=$idp_cutier;
$_SESSION['nmberkas']=$nm_berkas;
$_SESSION['ket_berkas']=$ket_berkas;

$_SESSION['reupload']=$upload_ulang;
$_SESSION['idberkas']=$id_berkas;

//echo $_SESSION['reupload'].'-'.$_SESSION['idberkas'];

error_reporting(E_ALL | E_STRICT);
require('UploadHandlerCuti.php');
$upload_handler = new UploadHandler();
