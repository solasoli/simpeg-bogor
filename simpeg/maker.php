<?
include("konek.php");
$q=mysqli_query($mysqli,"Select * from temp_maker where id_pegawai=0 and bulan>0 and tahun>0");
while($data=mysqli_fetch_array($q))
{
$nama=explode(" ","$data[nama]");
//$a=substr($data['karpeg'],0,1);
//$b=substr($data['karpeg'],-6);
$taon=substr($data['nip'],0,4);
$buk=substr($data['nip'],4,2);
$q1=mysqli_query($mysqli,"Select count(*) from pegawai where nama like '%$nama[2] $nama[3]%'");

//echo("Select count(*) from pegawai where no_karpeg like '%$a $b%' <br>");
$cel=mysqli_fetch_array($q1);

if($cel[0]==1)	
{
	
	$q2=mysqli_query($mysqli,"select id_pegawai from pegawai where nama like '%$nama[2] $nama[3]%' ");	
//echo("select id_pegawai from pegawai where  nama like'%$data[1]%' or nip_baru like '%$data[nip]%' or nip_lama like '%$data[nip]%'<br>");
$muncul=mysqli_fetch_array($q2);	
mysqli_query($mysqli,"update temp_maker set id_pegawai=$muncul[0] where id=$data[0]");
}
//else
//echo("Select count(*) from pegawai where nama like '%$data[1]%' or nip_baru like '%$data[nip]%' or  or nip_lama like '%$data[nip]%' <br>");
}
echo("done");
?>