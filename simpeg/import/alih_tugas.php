<?php

include "../konek.php";

$dinas_rs = mysql_query("SELECT * FROM gagal");
$i = 0;
while($dinas = mysql_fetch_array($dinas_rs))
{
	$q = "SELECT id_pegawai FROM pegawai 
		  WHERE pegawai.nip_baru = '$dinas[nip]' OR pegawai.nip_lama = '$dinas[nip]' LIMIT 0,1";
	
	$pegawai_rs = mysql_query($q);
							  
	//echo "$q <br />";
	
	
	if(mysql_num_rows($pegawai_rs) > 0)
	{
		$pegawai = mysql_fetch_array($pegawai_rs);
		
		// RIWAYAT MUTASI KERJA
		$riwayat_rs = mysql_query("SELECT * FROM riwayat_mutasi_kerja 
								  WHERE id_pegawai = '$pegawai[id_pegawai]' AND (keterangan = 'temporary') OR keterangan = 'Temporary' 
								  LIMIT 0,1");		
				
		
		if(mysql_num_rows($riwayat_rs) > 0)
		{
			$riwayat = mysql_fetch_array($riwayat_rs);
			
			// UPDATE WIWAYAT MUTASI KERja
			mysql_query("UPDATE riwayat_mutasi_kerja 
						SET pangkat_gol = '$pegawai[pangkat_gol]',
							keterangan = 'updated'
						WHERE id_riwayat = '$riwayat[id_riwayat]'");
						
			if($dinas[id_unit_kerja] != 0)
			{
				mysql_query("UPDATE riwayat_mutasi_kerja 
							SET id_unit_kerja = $dinas[id_unit_kerja]
							WHERE id_riwayat = '$riwayat[id_riwayat]'");
							
				if(mysql_affected_rows() > 0)
				{
					$sk_rs = mysql_query("SELECT * FROM sk 
									WHERE sk.id_sk = '$riwayat[id_sk]'");
									
					if(mysql_num_rows($sk_rs) > 0)
					{
						$sk = mysql_fetch_array($sk_rs);
						
						mysql_query("UPDATE sk
										SET no_sk = '$dinas[nomor_sk]',
										tgl_sk = '2010-12-27',
										pemberi_sk = 'Walikota Bogor',
										pengesah_sk = 'Dra. Hj. Fetty Qondarsyah, M.Si',
										keterangan = 'updated',
										tmt = '$dinas[tmt]'
									WHERE id_sk = '$riwayat[id_sk]'");
						
						if(mysql_affected_rows() > 0)
						{
							$i++;
						}		
						else
						{
							echo "SK dengan id $riwaya[id_sk] gagal <br/>";
						}			
					}
					else
					{
						echo "SK $riwayat[id_sk] Tidak ditemukan<br/>";
					}
				}			
				else
				{
					echo "Id_Riwayat $riwayat[id_riwayat] tidak terupdate <br/>";
				}
			}						
		}	
		else
		{
			echo "$pegawai[id_pegawai] - $pegawai[nama] - $pegawai[nip_baru] <br />";
		}
	}
	else
	{
		mysql_query("UPDATE gagal SET ketemu = 'false' WHERE id_dinas = '$dinas[id_dinas]'");
	}	
}

echo "$i FINISH";

?>
