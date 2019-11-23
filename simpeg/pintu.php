<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
include("konek.php");
$q=mysql_query("select * from unit_kerja where nama_baru not like 'SD%' and nama_baru not like 'SMP%' and nama_baru not like 'SMA%' and nama_baru not like 'TK%' and nama_baru not like 'SMK%' and nama_baru not like 'MAN%'  and nama_baru not like 'MTS%' and unit_kerja.tahun=2017 order by nama_baru");
extract($_POST);
?>
<form id="form1" name="form1" method="post" action="pintu.php">
  <label>
  <select name="unit" id="unit">
<?php
while($data=mysql_fetch_array($q))
{
if(@$unit==$data[0])
echo("<option value=$data[0] selected=selected>$data[nama_baru] </option>");
else
echo("<option value=$data[0]>$data[nama_baru] </option>");
}
?>
  </select>
  </label>
  <input type="submit" value="Tampilin(g)" />
</form>
<?php
if(isset($unit))
{
$q1=mysql_query("select nama,nip_baru,jfu_pegawai.jabatan from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai left join jfu_pegawai on jfu_pegawai.id_pegawai=pegawai.id_pegawai where id_j is null and jenjab like 'struktural'  and flag_pensiun=0 and current_lokasi_kerja.id_unit_kerja=$unit and  jfu_pegawai.id_pegawai is null");

?>
<table cellpadding="5" border="0" width="50%" align="center" cellspacing="0">
<tr><td> Nama </td><td>NIP </td><td>Aksi </td> </tr>
<?php while($ata=mysql_fetch_array($q1))
{
echo("<tr><td>$ata[0] </td><td>$ata[1] </td><td> $ata[2]</td></tr>");

}

?>
</table>
<?php
}
?>
</body>
</html>
