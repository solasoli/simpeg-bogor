<?

header("Content-type:application/vnd.ms-excel");

header("Content-Disposition:attachment;filename=bkn.xls");

$thn=2012;
include("pension.php");

?>