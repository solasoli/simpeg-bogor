<?php
include("koncil.php");
$q=mysql_query("select nip_baru,berkas.id_berkas,isi_berkas.id_isi_berkas,pegawai.id_pegawai from berkas inner join isi_berkas on berkas.id_berkas=isi_berkas.id_berkas inner join pegawai on pegawai.id_pegawai = berkas.id_pegawai where flag_pensiun=0 and file_name is null and id_kat=3");
while($data=mysql_fetch_array($q))
{
mysql_query("update isi_berkas set file_name='$data[0]-$data[1]-$data[2].jpg' where id_isi_berkas=$data[2]");
echo("update isi_berkas set file_name='$data[0]-$data[1]-$data[2].jpg' where id_isi_berkas=$data[2]<br>");

$q1=mysql_query("select id_pendidikan from pendidikan where id_pegawai=$data[3] order by level_p");	
$ata=mysql_fetch_array($q1);

mysql_query("update pendidikan set id_berkas=$data[1] where id_pendidikan=$ata[0]");
	
}
echo("done");
?>