<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="refresh" content="20;url=gawat.php">
<title>Untitled Document</title>
</head>

<body>
<?
include("konek.php");
$q0=mysqli_query($mysqli,"select * from gagal where ketemu='false' order by id_dinas");
while($data=mysqli_fetch_array($q0))
{

$q=mysqli_query($mysqli,"select count(*) from pegawai where nip_baru like '%$data[3]%' or nip_lama like '%$data[3]%'");
$cek=mysqli_fetch_array ($q);
if($cek[0]>0)
mysqli_query($mysqli,"update gagal set ketemu='ketemu' where id_dinas=$data[0]");
}
echo("done");

?>
</body>
</html>
