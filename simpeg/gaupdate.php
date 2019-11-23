<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from pegawai where flag_pensiun=0");
$i=0;
while($data=mysqli_fetch_array($q))
{


  $qsk=mysqli_query($mysqli,"select keterangan,id_berkas from sk where id_pegawai=$data[0] and id_kategori_sk=5 order by tmt desc ");


	   $sk=mysqli_fetch_array($qsk);
	   $banding=explode(",",$sk[0]);
	      if($banding[0]!=$data['pangkat_gol'] )
		  {
		  echo("$data[nama] $data[nip_baru] $banding[0] $data[pangkat_gol]<br>");
		  $i++;
		  }
}
echo("total =$i");
?>