<?php 
require_once("../konek.php");

function listing($dir){
	for($i=2; $i<count($dir); $i++)
	{
		echo "Searching for ".$dir[$i]."\n";
		$q = mysql_query("SELECT p.id_pegawai, no_sk, id_sk, p.nip_baru
						  FROM pegawai p 
						  INNER JOIN sk s ON s.id_pegawai = p.id_pegawai
						  WHERE nip_baru = $dir[$i] AND s.id_kategori_sk = 10
						  ORDER BY s.tmt DESC");						  
		
		$r = mysql_fetch_array($q);
		
		echo "Id pegawai = $r[0] and nomor sk = $r[1]\n";
		
		// Create new berkas
		$q = mysql_query("INSERT INT berkas
					      (
							id_pegawai,
							id_kat,
							nm_berkas,
							ket_berkas,
							tgl_upload,
							byk_hal,
							tgl_berkas,
							status,
							created_by,
							created_date
						  )
						  VALUES
						  (
							$r[id_pegawai],
							2,
							'SK Mutasi Jabatan',
							'',
							CURDATE(),
							1,
							'-',
							'BATCH UPLOADER',
							CURDATE()
						  )");
		$id_berkas = mysql_insert_id();
		
		// Update id_berkas di tabel sk
		mysql_query("UPDATE sk 
					 SET id_berkas = $id_berkas
					 WHERE id_sk = $r[id_sk]");
		
		// Foreach file
		$childs = scandir('batch/'.$dir[$i]);
		for($j=2; $j<count($childs); $j++)
		{
			echo $childs[$j]."\n";
			// Create new isi berkas
			mysql_query("INSERT INTO isi_berkas
						 (
							id_berkas,
							hal_ke,
							ket							
						 )
						 VALUES(
							$id_berkas,
							$j,
							'-'							
						 )");
			
			// Update file_name di table isi berkas
			$id_isi_berkas = mysql_insert_id();
			$file_name = '\\simpegserver\\htdocs\\simpeg\\Berkas\\".$r[nip_baru]."-".$id_berkas."-".$id_isi_berkas.".jpg';
			mysql_query("UPDATE isi_berkas SET file_name = $file_name");
			// Upload file
			move_uploaded_file('batch/'.$dir[$i].$childs[$j] , "../Berkas/".$file_name);
		}
		
		
		echo "\n";
	}
}

echo 'Loading..'."\n";
$dirs = scandir('batch');
listing($dirs);
?>