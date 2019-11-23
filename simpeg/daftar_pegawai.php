<?php 
	include_once "konek.php";
	
	// table counter unit_kerja	
	$q = "SELECT id_unit_kerja AS id, nama_baru AS nama, '0' AS jumlah
			FROM unit_kerja
			ORDER BY nama_baru ASC";
	
	$rs = mysqli_query($mysqli,$q);
	$counter = null;
	while($r = mysqli_fetch_array($rs)){
		$counter[] = $r;
	}	
	//print_r(count($counter));
	
	$q = "SELECT * FROM pegawai WHERE flag_pensiun = 0";
	$rs = mysqli_query($mysqli,$q);
		
	
	$pegawai = null;
	
	while($r = mysqli_fetch_array($rs)) {
			$pegawai[] = $r;
	}
	
	$q_empty = "DELETE FROM current_lokasi_kerja";
	mysqli_query($mysqli,$q_empty);
	
	$ada = 0;
	for($i=0; $i<count($pegawai); $i++){
			$id_pegawai = $pegawai[$i][id_pegawai];
			$id_unit_kerja = 0;
			// KALO PUNYA SK ALIH TUGAS atau Jabatan
			$q_sk = "SELECT p.id_pegawai, p.nama, r.id_unit_kerja, s . *
						FROM pegawai p
						INNER JOIN riwayat_mutasi_kerja r ON r.id_pegawai = p.id_pegawai
						INNER JOIN unit_kerja u ON u.id_unit_kerja = r.id_unit_kerja
						INNER JOIN sk s ON s.id_sk = r.id_sk
						WHERE p.id_pegawai = ".$pegawai[$i][id_pegawai]."
						AND u.tahun =2011
						AND (
						id_kategori_sk =1
						OR id_kategori_sk =10
						)
						ORDER BY s.tmt DESC
						LIMIT 0 , 1";	
			
			$rs_sk = mysqli_query($mysqli,$q_sk);
			
			if(mysqli_num_rows($rs_sk) > 0){
				$sk = mysqli_fetch_array($rs_sk);
					
		
							
				for($i_uker=0; $i_uker < count($counter); $i_uker++){
					if($sk[id_unit_kerja] == $counter[$i_uker][id])
					{
							$counter[$i_uker][jumlah]=$counter[$i_uker][jumlah]+1;
					}						
				}	
				$id_unit_kerja = $sk[id_unit_kerja];		
				$ada++;
			}
			else {				
					//KALO GA PUNYA SK Alih tugas dan SK Mutasi JABATAN
					$q_sk = "SELECT * 
						FROM riwayat_mutasi_kerja r  
						WHERE r.id_pegawai = ".$pegawai[$i][id_pegawai]. 
						" ORDER BY r.id_riwayat DESC
						LIMIT 0,1";
						//echo $q_sk;
					$rs_sk = mysqli_query($mysqli,$q_sk);
					
					if(mysqli_num_rows($rs_sk) > 0){
						$sk = mysqli_fetch_array($rs_sk);
										
						for($i_uker=0; $i_uker < count($counter); $i_uker++){
							if($sk[id_unit_kerja] == $counter[$i_uker][id])
							{
									$counter[$i_uker][jumlah]=$counter[$i_uker][jumlah]+1;
							}						
						}			
						$id_unit_kerja = $sk[id_unit_kerja];
						$max_funct++;
					}	
					else{
						$unknown++;				
						echo $pegawai[$i][id_pegawai]."<br/>";	
					}						
			}
				//echo $pegawai[$i][id_pegawai]." - ".$pegawai[$i][nama]." - ".$pegawai[$i][ponsel]."<br/>";	
				$q_insert = "INSERT INTO current_lokasi_kerja (id_pegawai, id_unit_kerja) VALUES ('$id_pegawai', '$id_unit_kerja')";
				mysqli_query($mysqli,$q_insert);
	}
?>
	



	
<?php	
	echo "<hr/>";
	echo "Total pegawai             : ".count($pegawai)."<br/>";
	echo "Yg pake SK Alih Tugas     : ".$ada."<br/>";
	echo "Yg pake SK Mutasi Jabatan : ".$mutjab."<br/>";
	echo "Yg pake SK MAX Function   : ".$max_funct."<br/>";	
	echo "Tidak Terdeteksi          : ".$unknown."<br/>";
	
?>