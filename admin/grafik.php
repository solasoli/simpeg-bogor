<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?
include("koncil.php");
$q=mysql_query("select count(*) from pegawai where flag_pensiun=0 ");
$data=mysql_fetch_array($q);
$q5=mysql_query("select * from (select count(*) as x,id_kat,berkas.id_berkas from isi_berkas inner join berkas on berkas.id_berkas=isi_berkas.id_berkas where file_name like '%jpg%' group by id_kat,berkas.id_berkas) as y ");
?>
</body>
</html>