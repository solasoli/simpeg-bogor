<?php
session_start();
include("konek.php");
extract($_POST);

/*

$qnip=mysql_query("select nip_baru from pegawai  where id_pegawai=$idp");
$ata=mysql_fetch_array($qnip);

$fspuk=$_FILES['antar'];
if($fspuk['size']>0)
{
$spuk=1;
mysql_query("insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by) values ($idp,21,'Surat Pengantar Dari Unit Kerja','$ay','$uploader[0]')");
$idberkas=mysql_insert_id();

mysql_query("insert into isi_berkas (id_berkas) values ($idberkas)");
$idisi=mysql_insert_id();

$nf="\\192.168.1.2\\htdocs\\simpeg\\Berkas\\".$ata[0]."-".$idberkas."-".$idisi.".jpg";
mysql_query("update isi_berkas set file_name='$nf' where id_isi_berkas=$idisi");

move_uploaded_file($fspuk['tmp_name'],"./Berkas/".$fspuk['name']);	
rename("./Berkas/".$fspuk['name'],"./Berkas/".$ata[0]."-".$idberkas."-".$idisi.".jpg");}
else
$spuk=0;

$fspal=$_FILES['nyata'];
if($fspal['size']>0)
$spal=1;
else
$spal=0;

$fskt=$_FILES['sk'];
if($fskt['size']>0)
$skt=1;
else
$skt=0;


$fdp3=$_FILES['dp3'];
if($fdp3['size']>0)
$dp3=1;
else
$dp3=0;


$fijazah=$_FILES['ij'];
if($fijazah['size']>0)
$ijazah=1;
else
$ijazah=0;


$fkmpt=$_FILES['terima'];
if($fkmpt['size']>0)
$kmpt=1;
else
$kmpt=0;

$fjk=$_FILES['jadwal'];
if($fjk['size']>0)
$jk=1;
else
$jk=0;



$fjm=$_FILES['ajar'];
if($fjm['size']>0)
$jm=1;
else
$jm=0;


$fkkg=$_FILES['butuh'];
if($fkkg['size']>0)
$kkg=1;
else
$kkg=0;
*/
 echo("hahahah");
?>
</body>
</html>