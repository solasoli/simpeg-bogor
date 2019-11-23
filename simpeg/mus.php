<?
include("konek.php");
$q=mysql_query("Select * from llaj where id_pegawai=0");
while($data=mysql_fetch_array($q))
{
$nama=explode(" ","$data[nama]");
//$a=substr($data['karpeg'],0,1);
//$b=substr($data['karpeg'],-6);
$taon=substr($data['tgl'],0,4);
$buk=substr($data['nip'],4,2);


$q1=mysql_query("Select count(*) from pegawai where nama ='$data[nama]'");

//echo("Select count(*) from pegawai where no_karpeg like '%$a $b%' <br>");
$cel=mysql_fetch_array($q1);

if($cel[0]==1)	
{
	
	$q2=mysql_query("select id_pegawai from pegawai where nama ='$data[nama]'");	
//echo("select id_pegawai from pegawai where  nama like'%$data[1]%' or nip_baru like '%$data[nip]%' or nip_lama like '%$data[nip]%'<br>");
$muncul=mysql_fetch_array($q2);	

$q3=mysql_query("select id_unit_kerja,max(tmt)as d  from riwayat_mutasi_kerja inner join sk on sk.id_sk=riwayat_mutasi_kerja.id_sk where riwayat_mutasi_kerja.id_pegawai=4181 group by id_unit_kerja order by max(tmt) desc");
$unit=mysql_fetch_array($q3);

if($unit[0]=3586)
mysql_query("update llaj set id_pegawai=$muncul[0] where id=$data[0]");
}
//else
//echo("Select count(*) from pegawai where nama like '%$data[1]%' or nip_baru like '%$data[nip]%' or  or nip_lama like '%$data[nip]%' <br>");
}
echo("done");
?>