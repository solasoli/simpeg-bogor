<?
extract($_POST);
$qc=mysqli_query($mysqli,"select count(*),eselon from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j group by eselon order by eselon"); 
	while($crut=mysqli_fetch_array($qc))
	{
	
	
	}
?>