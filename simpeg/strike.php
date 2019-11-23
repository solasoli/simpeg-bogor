<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body,td,th {
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 11px;
}
</style>
</head>

<body>
<?
include("konek.php");
extract($_POST);
$q=mysqli_query($mysqli,"select nama,nip_lama,nip_baru,ponsel,telepon,pegawai.id_pegawai,id_j,email,jenjab 
				from pegawai inner join current_lokasi_kerja  on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai 
				where flag_pensiun=0 and id_unit_kerja=$u  group by pegawai.id_pegawai order by pegawai.jenjab,nama");

//echo("select nama,nip_lama,nip_baru,ponsel,telepon,pegawai.id_pegawai,id_j from pegawai inner join current_lokasi_kerja  on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where flag_pensiun=0 and id_unit_kerja=$u order by id_j desc");

?>
<div align="center">ID UNIT KERJA=<? echo($u); ?> </div>
<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td bgcolor="#999999">no</td>
    <td bgcolor="#999999">Nama</td>
    <td bgcolor="#999999">NIP</td>
    <td nowrap="nowrap" bgcolor="#999999">NIP baru</td>
    <td nowrap="nowrap" bgcolor="#999999">Jabatan</td>
     <td nowrap="nowrap" bgcolor="#999999">Jenjang Jabatan</td>
    <td bgcolor="#999999">telp rumah</td>
    <td bgcolor="#999999">ponsel</td>
    <td bgcolor="#999999">email</td>
       <td nowrap="nowrap" bgcolor="#999999">edit ponsel &amp; email</td>
  </tr>
  <?
  $i=1;
  while($data=mysqli_fetch_array($q))
  {
	  
	  if($data[6]==0)
	  $jab="Staf Pelaksana";
	  else
	  {
$qj=mysqli_query($mysqli,"select jabatan from jabatan where id_j=$data[6]");
//echo("select jabatan from jabatan where id_j=$data[6]");
$pej=mysqli_fetch_array($qj);
$jab=$pej[0];
	  }
if($i%2==0)
echo("<tr>");
else
echo("<tr bgcolor=#f0f0f0>");
echo(" 
    <td>$i</td>
    <td nowrap>$data[0]</td>
    <td nowrap>$data[1]</td>
	  <td nowrap>$data[2]</td>
	  <td >$jab</td>
	    <td >$data[8]</td>
    <td nowrap>$data[4]</td>
    <td>$data[3]</td>
	  <td>$data[7]</td>
	  <td><a href=formupdate.php?id=$data[5]&u=$u> edit </a></td>
  </tr>");
  $i++;
	  
  }
  ?>
</table>
</body>
</html>