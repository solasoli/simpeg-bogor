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
extract($_POST);
include("konek.php");

if($n==NULL)
$n="<>'NULL'";
else
$n=" like '%$n%'";

if($ag==1)
$ag=" ";
else
$ag=" and agama='$ag'";


if($es==1)
$es=" ";
else
$es=" and jabatan.eselon LIKE '%$es%'";


if($pg==1)
$pg=" ";
else
$pg=" and pangkat_gol='$pg'";

if($jk==1)
$jk=" ";
else
$jk=" and jenis_kelamin='$jk'";

if($ja==NULL)
$ja=" ";
else
$ja=" and jabatan.jabatan LIKE '%$ja%'";

if($nip==NULL)
$nip=" ";
else
$nip=" and  (nip_lama like '%$nip%' or nip_baru like '%$nip%')";



if($uk==NULL)
$uk="<>'NULL'";
else
{$anam=mysqli_query($mysqli,"select id_unit_kerja from unit_kerja where nama_baru like '%$uk%'");
$ana=mysqli_fetch_array($anam);
if($ana[0]!=NULL)
$uk="=$ana[0]";
else
$uk="<>'NULL'";
}
$q=mysqli_query($mysqli,"SELECT * FROM 
(
  SELECT * FROM 
  (
    SELECT   pegawai.id_pegawai AS 'id_pegawai',
             pegawai.id_j AS 'id_j',
             pegawai.flag_pensiun,
             pegawai.nip_lama AS 'nip_lama',
             pegawai.nip_baru AS 'nip_baru',
             pegawai.nama AS 'nama',
             pegawai.nama_pendek AS 'nama_pendek',
             pegawai.Jenis_kelamin AS 'jenis_kelamin',
             pegawai.npwp AS 'npwp',
             pegawai.agama AS 'agama',
             pegawai.tempat_lahir AS 'tempat_lahir',
             pegawai.tgl_lahir AS 'tgl_lahir',
             pegawai.status_pegawai AS 'status_pegawai',
             pegawai.pangkat_gol AS 'pangkat_gol',
             unit_kerja.id_unit_kerja AS 'id_unit_kerja'
    FROM pegawai 
    LEFT OUTER JOIN riwayat_mutasi_kerja ON pegawai.id_pegawai = riwayat_mutasi_kerja.id_pegawai 
    LEFT OUTER JOIN unit_kerja ON riwayat_mutasi_kerja.id_unit_kerja = unit_kerja.id_unit_kerja 
    LEFT OUTER JOIN sk ON riwayat_mutasi_kerja.id_sk=sk.id_sk 
    ORDER BY sk.tgl_sk desc
  ) AS x 
  GROUP BY id_pegawai
) AS y 
INNER JOIN pendidikan ON pendidikan.id_pegawai = y.id_pegawai
LEFT OUTER JOIN jabatan ON jabatan.id_j = y.id_j
WHERE flag_pensiun = 0 and y.id_unit_kerja $uk and nama $n $nip $ag $jk $pg $es $ja
ORDER BY pangkat_gol DESC, nama,level_p 
 ");

/*--------------------------------------- KUERI -------------------------------
SELECT * FROM 
(
  SELECT * FROM 
  (
    SELECT   pegawai.id_pegawai AS 'id_pegawai',
             pegawai.id_j AS 'id_j',
             pegawai.flag_pensiun,
             pegawai.nip_lama AS 'nip_lama',
             pegawai.nip_baru AS 'nip_baru',
             pegawai.nama AS 'nama',
             pegawai.nama_pendek AS 'nama_pendek',
             pegawai.Jenis_kelamin AS 'jenis_kelamin',
             pegawai.npwp AS 'npwp',
             pegawai.agama AS 'agama',
             pegawai.tempat_lahir AS 'tempat_lahir',
             pegawai.tgl_lahir AS 'tgl_lahir',
             pegawai.status_pegawai AS 'status_pegawai',
             pegawai.pangkat_gol AS 'pangkat_gol',
             unit_kerja.id_unit_kerja AS 'id_unit_kerja'
    FROM pegawai 
    LEFT OUTER JOIN riwayat_mutasi_kerja ON pegawai.id_pegawai = riwayat_mutasi_kerja.id_pegawai 
    LEFT OUTER JOIN unit_kerja ON riwayat_mutasi_kerja.id_unit_kerja = unit_kerja.id_unit_kerja 
    LEFT OUTER JOIN sk ON riwayat_mutasi_kerja.id_sk=sk.id_sk 
    ORDER BY sk.tgl_sk desc
  ) AS x 
  GROUP BY id_pegawai
) AS y 
INNER JOIN pendidikan ON pendidikan.id_pegawai = y.id_pegawai
LEFT OUTER JOIN jabatan ON jabatan.id_j = y.id_j
WHERE flag_pensiun = 0 and y.id_unit_kerja = 5 and nama LIKE '%%'  and jabatan.jabatan LIKE '%%' and jabatan.eselon LIKE '%I%'
ORDER BY pangkat_gol DESC, nama
*/


?>
<body>


<?
$i=1;
$tes=mysqli_fetch_array($q);
if($tes[0]!=NULL)
{
$q=mysqli_query($mysqli,"SELECT * FROM 
(
  SELECT * FROM 
  (
    SELECT   pegawai.id_pegawai AS 'id_pegawai',
             pegawai.id_j AS 'id_j',
             pegawai.flag_pensiun,
             pegawai.nip_lama AS 'nip_lama',
             pegawai.nip_baru AS 'nip_baru',
             pegawai.nama AS 'nama',
             pegawai.nama_pendek AS 'nama_pendek',
             pegawai.Jenis_kelamin AS 'jenis_kelamin',
             pegawai.npwp AS 'npwp',
             pegawai.agama AS 'agama',
             pegawai.tempat_lahir AS 'tempat_lahir',
             pegawai.tgl_lahir AS 'tgl_lahir',
             pegawai.status_pegawai AS 'status_pegawai',
             pegawai.pangkat_gol AS 'pangkat_gol',
             unit_kerja.id_unit_kerja AS 'id_unit_kerja'
    FROM pegawai 
    LEFT OUTER JOIN riwayat_mutasi_kerja ON pegawai.id_pegawai = riwayat_mutasi_kerja.id_pegawai 
    LEFT OUTER JOIN unit_kerja ON riwayat_mutasi_kerja.id_unit_kerja = unit_kerja.id_unit_kerja 
    LEFT OUTER JOIN sk ON riwayat_mutasi_kerja.id_sk=sk.id_sk 
    ORDER BY sk.tgl_sk desc
  ) AS x 
  GROUP BY id_pegawai
) AS y 
INNER JOIN pendidikan ON pendidikan.id_pegawai = y.id_pegawai
LEFT OUTER JOIN jabatan ON jabatan.id_j = y.id_j
WHERE flag_pensiun = 0 and y.id_unit_kerja $uk and nama $n $nip $ag $jk $pg $es $ja
ORDER BY pangkat_gol DESC, nama,level_p 
 ");
 


while($data=mysqli_fetch_array($q))
{


$base=7;
$qc=mysqli_query($mysqli,"select count(*) from pendidikan where id_pegawai=$data[0]");
$co=mysqli_fetch_array($qc);
$ro=$base+$base;
echo("
<div align='left'>
<table border=2 >

<td rowspan=$ro style='max-width: 20px; min-width:20px;' align=right>$i
</td>
<td rowspan=$ro width=75 valign=middle >");
if (file_exists("./foto/$data[id_pegawai].jpg")) 
	$gambar="<img src=./foto/$data[id_pegawai].jpg width=75 />";
else if (file_exists("./foto/$data[id_pegawai].JPG")) 
	$gambar="<img src=./foto/$data[id_pegawai].JPG width=75 />";
else
{
if($data['jenis_kelamin']=='L')
	$gambar="<img src=./images/male.jpg width=75 />";
else
	$gambar="<img src=./images/female.jpg width=75 />";
}
echo $gambar;
echo ("</td><td><table> ");
$k=mysqli_query($mysqli,"select nama_baru from riwayat_mutasi_kerja inner join pegawai on riwayat_mutasi_kerja.id_pegawai=pegawai.id_pegawai inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja inner join sk on riwayat_mutasi_kerja.id_sk=sk.id_sk where riwayat_mutasi_kerja.id_pegawai=$data[id_pegawai] order by tgl_sk desc");


				
$unit=mysqli_fetch_array($k);
	
	
	if($data[3]=='-')
		$nip=$data[4];
	else
		$nip=$data[3];
	
$tgl = substr($data['tgl_lahir'],8,2);
$bln = substr($data['tgl_lahir'],5,2);
$thn = substr($data['tgl_lahir'],0,4);

$coba="$tgl/$bln/$thn";
//nama
echo("<tr><td width=75> Nama</td><td width=5>:</td><td nowrap><a href=index2.php?x=home3.php&&id=$data[id_pegawai]&&s=$s>$data[nama]</a> </td></tr>");
//ttl
echo("<tr><td> Tgl Lahir</td><td>:</td><td>$coba </td></tr>");
//nip
echo("<tr><td> NIP lama</td><td>:</td><td>$data[nip_lama] </td></tr>");
//nip baru
echo("<tr><td> NIP Baru</td><td>:</td><td>$data[nip_baru]</td></tr>");
//unit kerja
echo("<tr><td nowrap> Unit Kerja</td><td>:</td><td nowrap>$unit[0]</td></tr>");
//golongan
//unit kerja
echo("<tr><td nowrap> Golongan</td><td>:</td><td nowrap>$data[pangkat_gol]</td></tr>");

echo("<tr><td nowrap> Jabatan</td><td>:</td><td nowrap>Staf Pelaksana</td></tr>");



}
echo("</table></div></td></tr>");
  $i++;
}
else
{
echo("<div align=center> Data Tidak Ditemukan</div>");
include("advance.php");
}
?>



  

</table>
</body>
</html>
	