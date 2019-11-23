<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">

.satu {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	color: #00C;
}
</style>
</head>

<body>
<?
extract($_GET);
extract($_POST);
include("konek.php");
$skr=date("Y-m-d");
$qada=mysqli_query($mysqli,"Select count(*) from chat where id_ngajak=$gw and id_diajak=$chat and left(start_chat,10)='$skr'");
$ada=mysqli_fetch_array($qada);

$qada2=mysqli_query($mysqli,"Select count(*) from chat where id_ngajak=$chat and id_diajak=$gw and left(start_chat,10)='$skr'");
$ada2=mysqli_fetch_array($qada2);


if($ada[0]>0)
$qc=mysqli_query($mysqli,"Select obroloi from chat where id_ngajak=$gw and id_diajak=$chat and left(start_chat,10)='$skr'");

if($ada2[0]>0)
$qc=mysqli_query($mysqli,"Select obroloi from chat where id_ngajak=$chat and id_diajak=$gw and left(start_chat,10)='$skr'");


//echo("Select obroloi from chat where id_ngajak=$gw and id_diajak=$chat and left(start_chat,10)='$skr'");

if($qc)
{
$coi=mysqli_fetch_array($qc);
echo($coi[0]);
}
?>
</body>
</html>