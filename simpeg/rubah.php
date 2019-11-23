
<?

include("konek.php");
$q=mysqli_query($mysqli,"Select * from temp_maker where id_pegawai=0 ");
while($data=mysqli_fetch_array($q))
{
	$taon=substr($data['tmt'],0,4);
$q1=mysqli_query($mysqli,"Select count(*) from sk where id_pegawai=$data[id_pegawai] and id_kategori_sk=5 and tmt like '$taon%'");
$cek=mysqli_fetch_array($q1);

if($cek[0]==0)
mysqli_query($mysqli,"update mus2 set rubah=1 where id_mus=$data[0]");	
}

echo("done");
?>