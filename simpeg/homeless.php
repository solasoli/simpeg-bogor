<?php
include("konek.php");
$q=mysql_query("select id,left(nip,12) from homeless where id_pegawai=0");
while($data=mysql_fetch_array($q))
{
	$qc=mysql_query("select id_pegawai from pegawai where nip_baru like '$data[1]%'");
	$cek=mysql_fetch_array($qc);
	if($cek[0]!=NULL)
	{
	mysql_query("update homeless set id_pegawai=$cek[0] where id=$data[0]");
	//echo("udpate homesless set id_pegawai=$cek[0] where id=$data[0]<br>");
	}
}
echo("done.php");


?>