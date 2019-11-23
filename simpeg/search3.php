<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #737373;
}
-->
</style></head>
<?php
$s=$_REQUEST['s'];
include("konek.php");
$q=mysql_query("select nama,nama_baru,pegawai.id_pegawai,nip_lama,nip_baru,tgl_lahir from pegawai inner join riwayat_mutasi_kerja on pegawai.id_pegawai=riwayat_mutasi_kerja.id_pegawai inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where nama like '%$s%' or nama_baru like '%$s%' group by id_pegawai,nip_lama,nip_baru  order by nama ");
?>
<body>
<div align="center" id="txtHint" >

</div>
</body>
</html>
