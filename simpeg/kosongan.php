<?
include("konek.php");


  
  $qko=mysqli_query($mysqli,"select jabatan,jabatan.id_j from kosong_jabatan inner join jabatan on jabatan.id_j=kosong_jabatan.id_j where jabatan not like '%walikota%'");
  while($kos=mysqli_fetch_array($qko))
  {
	  $qada=mysqli_query($mysqli,"select count(*) from mutasi_jabatan where id_j=$kos[1]");
	 
	  $ada=mysqli_fetch_array($qada);
	  if($ada[0]==0)
  echo("&nbsp;&nbsp;&nbsp;<a href=pegawai.php?k=$kos[1]>$kos[0]</a><br> ");
  
  }
  
  $qko2=mysqli_query($mysqli,"select id_pegawai from mutasi_jabatan ");
  while($koso=mysqli_fetch_array($qko2))
  {
	  
	  	$qj=mysqli_query($mysqli,"Select sk.id_j,jabatan.jabatan from sk inner join jabatan on jabatan.id_j=sk.id_j where sk.id_pegawai=$koso[0] and id_kategori_sk=10 order by tmt desc ");  
	  $bj=mysqli_fetch_array($qj);
	  if($bj[0]!=NULL)
	  {
	  $qjo=mysqli_query($mysqli,"select count(*) from mutasi_jabatan where id_j=$bj[0]");
	  $kejo=mysqli_fetch_array($qjo);
	  if($kejo[0]==0)
	   echo("&nbsp;&nbsp;&nbsp;<a href=pegawai.php?k=$bj[0]>$bj[1]</a><br> ");
	  }
  }
 
?>