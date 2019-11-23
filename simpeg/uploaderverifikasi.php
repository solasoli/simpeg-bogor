<?php
    session_start();
    error_reporting(E_ALL | E_STRICT);
    if(isset($_GET['filesnya'])){
        $_SESSION['fileBerkasnya']=$_GET['filesnya'];
    }
    if(isset($_GET['idberkasnya'])){
        $_SESSION['idBerkasnya']=$_GET['idberkasnya'];
    }
    if(isset($_GET['idawal'])){
        $_SESSION['idAwalVerif']=$_GET['idawal'];
    }
    if(isset($_GET['jenis'])){
        $_SESSION['jenisVerif']=$_GET['jenis'];
    }
    if(isset($_GET['nm_berkas'])){
        $_SESSION['nmBerkasnya']=$_GET['nm_berkas'];
    }
    if(isset($_GET['ket_berkas'])){
        $_SESSION['ketBerkasnya']=$_GET['ket_berkas'];
    }
    if(isset($_GET['idpeg'])){
        $_SESSION['idPegawainya']=$_GET['idpeg'];
    }
    require('UploadHandlerBerkas.php');
    $upload_handler = new UploadHandler();

?>