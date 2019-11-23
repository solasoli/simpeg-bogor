Untuk memasukkan Pendidikan Terakhir
<?php

require_once("../../konek.php");

$q = mysql_query("SELECT *
						FROM `MUS2`
						WHERE id_pegawai != 0 AND ijasah != '-'");
					
echo mysql_num_rows($q)."<br/>";					
while($r = mysql_fetch_array($q))
{
	switch($r['ijasah']) {
				case 1 :
				$tingkat_pendidikan = "S3";
		break;
				case 2 : 
				$tingkat_pendidikan = "S2";
		break;
				case 3 : 
				$tingkat_pendidikan = "S1";
		break;
				case 4 : 
				$tingkat_pendidikan = "D#";
		break;
				case 5 : 
				$tingkat_pendidikan = "D2";
		break;
				case 6 : 
				$tingkat_pendidikan = "D1";
		break;
				case 7 : 
				$tingkat_pendidikan = "SMU/SMK/MA/SEDERAJAT";
		break;
				case 8 : 
				$tingkat_pendidikan = "SMP/MTs/SEDERAJAT";
		break;
				case 9 : 
				$tingkat_pendidikan = "SD/SEDERAJAT";
		break;		
	}
		
	$q_insert = "";
	$q2 = "SELECT MIN(level_p) AS min_level_p FROM pendidikan WHERE id_pegawai = $r[id_pegawai]";	
	$rs = mysql_query($q2);
	$pend = mysql_fetch_array($rs);		
	if($pend[min_level_p] != "")
	{
		if(($r[ijasah] < $pend[min_level_p]) && ($pend[level_p] != 0))
		{	
			echo "NAMBAH $r[id_pegawai] - $r[ijasah] - $pend[min_level_p]<br/>";			
			$q_insert = "INSERT INTO pendidikan(id_pegawai, tingkat_pendidikan, tahun_lulus, level_p) 
						 VALUES( '$r[id_pegawai]', '$tingkat_pendidikan', '".$r['tahun ijasah']."', '$r[ijasah]' )";					
		}	
	}
	else
	{
		echo "baru $r[id_pegawai] - $r[ijasah] - $pend[min_level_p]<br/>";	
		echo "$q2<br/>";	
		$q_insert = "INSERT INTO pendidikan(id_pegawai, tingkat_pendidikan, tahun_lulus, level_p) 
						 VALUES( '$r[id_pegawai]', '$tingkat_pendidikan', '".$r['tahun ijasah']."', '$r[ijasah]' )";	
	}
	
	if($q_insert != "")
	{
		mysql_query($q_insert);
	}
}

?>
