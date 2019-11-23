<?


include("konek.php");
$q=mysqli_query($mysqli,"select id_pegawai from oegawai where id_j=0 and flag_pensiun=0");
while($data=mysqli_fetch_array($q))
{

$q1=mysqli_query($mysqli,"select count(*) from sk where id_pegawai=$data[0] and id_kategori_sk=1 and tmt like '2011-%'");	
	$cek=mysqli_fetch_array($q1);
	
	if($cek[0]==1)
	{
	$q2=mysqli_query($mysqli,"select id_sk from sk where id_pegawai=$data[0] and id_kategori_sk=1 and tmt like '2011-%'");
		$ek=mysqli_fetch_array($q2);
		
		$q3=mysqli_query($mysqli,"select count(*)from riwayat_mutasi_kerja where id_sk=$ek[0]");
		$k=mysqli_fetch_array($q3);
		
		if($k[0]==0)
		echo("id $data[0] belum ada sk rmk <br>");
		else
		{
		$q4=mysqli_query($mysqli,"select id_unit_kerja,id_riwayat from riwayat_mutasi_kerja where id_sk=$ek[0]");
		$bek=mysqli_fetch_array($q4);
		
		
		if($bek[0]<=3562)
		{
		$q5=mysqli_query($mysqli,"select nama_baru from unit_kerja where id_unit_kerja=$bek[0]");
		$unit=mysqli_fetch_array($q5);
		
		
		$q6=mysqli_query($mysqli,"select count(*) from unit_kerja where nama_lama='$unit[0]'");
		$cok=mysqli_fetch_array($q6);
		
		if($cok[0]==1)
		{
			
			$q7=mysqli_query($mysqli,"select id_unit_kerja from unit_kerja where nama_lama='$unit[0]' and tahun=2011");
		$cik=mysqli_fetch_array($q7);
		
		mysqli_query($mysqli,"udpate riwayat_mutasi_kerja set id_unit_kerja=$cik[0] where id_riwayat=$bek[1]");
		mysqli_query($mysqli,"udpate current_lokasi_kerja set id_unit_kerja=$cik[0] where id_pegawai=$data[0]");		
		
		}
		else
		{
		if($cok[0]>1)	
		echo("id antara 2unit_kerja <br> ");	
		}
		
		
		}
			
		}
		
	}
	
}
?>