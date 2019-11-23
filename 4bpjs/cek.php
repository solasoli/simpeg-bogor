<?php
extract($_POST);
include("koneksi.php");
if($nip=='administrator' and $pass=='interop2018')
{
session_start();
$_SESSION['id']='1';
$_SESSION['jab']='2';

header("location:menu.php");


}
else
{
$message="Username / Password Salah";
include("index.php");
}

?>