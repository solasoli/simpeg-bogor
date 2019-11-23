<?php
session_start();
require "konek.php";

if(!$_POST[upload_only])
{
	$tglDibuat = substr($_POST[tgl_dibuat], 6, 4)."-".substr($_POST[tgl_dibuat], 3, 2)."-".substr($_POST[tgl_dibuat], 0, 2);
	$tglDiterimaAtasan = substr($_POST[tgl_diterima_atasan], 6, 4)."-".substr($_POST[tgl_diterima_atasan], 3, 2)."-".substr($_POST[tgl_diterima_atasan], 0, 2);
	$tglDiterimaPegawai = substr($_POST[tgl_diterima_pegawai], 6, 4)."-".substr($_POST[tgl_diterima_pegawai], 3, 2)."-".substr($_POST[tgl_diterima_pegawai], 0, 2);
	
	$qInsertDp3 = "INSERT INTO dp3
					(
						id_pegawai,
						id_berkas,
						tahun,
						nama,
						nip,
						pangkat_gol,
						jabatan,
						unit_kerja,
						nama_penilai,
						nip_penilai,
						pangkat_penilai,
						jabatan_penilai,
						unit_kerja_penilai,
						nama_atasan_penilai,
						nip_atasan_penilai,
						pangkat_atasan_penilai,
						jabatan_atasan_penilai,
						unit_kerja_atasan_penilai,
						keberatan,
						tanggapan_pejabat_penilai,
						keputusan_atasan_penilai,
						lain_lain,
						nilai_a,
						nilai_b,
						nilai_c,
						nilai_d,
						nilai_e,
						nilai_f,
						nilai_g,
						nilai_h,
						nilai_i,
						nilai_j,
						tanggal_dibuat,
						tanggal_diterima_pegawai,
						tanggal_diterima_atasan 
					)
					VALUES
					(
						'$_SESSION[id_pegawai]', 
						'0',
						'$_POST[tahun]',
						'-',
						'-',
						'-',
						'-',
						'-',
						'-',
						'-',
						'-',
						'-',
						'-',
						'-',
						'-',
						'-',
						'-',
						'-',
						'-',
						'-',
						'-',
						'-',
						'0',
						'0',
						'0',
						'0',
						'0',
						'0',
						'0',
						'0',
						'0',
						'0',
						'$tglDibuat',
						'$tglDiterimaPegawai',
						'$tglDiterimaAtasan'						
					)";
					
	$qInsertBerkas = "INSERT INTO berkas
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
					  	$_SESSION[id_pegawai],
					  	$_POST[id_kategori_berkas],
					  	'DP3',
					  	'-',
					  	CURDATE(),
					  	'0',
					  	'$tglDibuat',
					  	'-',
					  	'$_SESSION[nip_baru]',
					  	CURDATE()
					  )";
					  
	// Check for file extension and size
	$isValid = true;				
	foreach($_FILES as $f)
	{
		if($f[size] > 0)
			if($f[type] != 'image/jpeg')
			{			
				//////echo "Image type invalid.";
				$isValid = false;
				return;
			}			
	}			
	
	if($isValid)
	{
		// INSERT DP3
		$lastIdDp3;
		//echo "INSERT DP3: $qInsertDp3 <br/>";
		if(mysqli_query($mysqli,$qInsertDp3))
		{
			$lastIdDp3 = mysqli_insert_id();
		}
			
		// INSERT BERKAS
		$lastIdBerkas;
		//echo "INSERT BERKAS: $qInsertBerkas <br/>";
		if(mysqli_query($mysqli,$qInsertBerkas))
		{
			$lastIdBerkas = mysqli_insert_id();
		}
		
		// UPDATE id_berkas in DP3 table
		$qUpdateDp3 = "UPDATE dp3 SET id_berkas = $lastIdBerkas WHERE id = $lastIdDp3";
		//echo "UPDATE ID BERKAS: $qUpdateDp3 <br/>";
		mysqli_query($mysqli,$qUpdateDp3);
					
		// UPLOAD FILE	
		$i = 1;
		foreach($_FILES as $f)
		{
			//print_r($f);
			if($f[size] > 0)
			{		
				// INSERT DETAIL BERKAS	
				$qInsertDetail = "INSERT INTO isi_berkas (id_berkas, hal_ke, ket)
								  VALUES ($lastIdBerkas, $i, 'ket')";
				//echo $qInsertDetail;
				$lastIdDetail;
				//echo "INSERT DETAIL BERKAS: $qInsertDetail <br/>";
				if(mysqli_query($mysqli,$qInsertDetail))
				{
					$lastIdDetail = mysqli_insert_id();
				}
				$path = addslashes("\\\\simpegserver\\htdocs\\simpeg\\Berkas\\");
				
				$fileName = "$_SESSION[nip_baru]-$lastIdBerkas-$lastIdDetail.jpg";
				
				//UPDATE filename in DETAIl BERKAS
				$qUpdateDetail = "UPDATE isi_berkas SET file_name = '".$path.$fileName."' WHERE id_isi_berkas = $lastIdDetail";
				//echo "UPDATE FILENAME: $qUpdateDetail <br/>";
				mysqli_query($mysqli,$qUpdateDetail);
				
				// UPLOAD FILE
				//echo "UPLOAD FILE: $f[file][tmp_name] ke Berkas/" . $fileName;
				move_uploaded_file($f[tmp_name], "Berkas/" . $fileName);
			}			
			$i++;
		}						
	}
}
else 
	
	
// UPDATE FILE ONLY	
{
	// Check for file extension and size
	$isValid = true;				
	foreach($_FILES as $f)
	{
		if($f[size] > 0)
			if($f[type] != 'image/jpeg')
			{			
				//echo "Image type invalid.";
				$isValid = false;
				return;
			}			
	}
	
	if($isValid)
	{
		$qDp3 = "SELECT tanggal_dibuat FROM dp3 WHERE id = $_POST[id_dp3]";
		
		$rsDp3 = mysqli_query($mysqli,$qDp3);
		$rDp3 = mysqli_fetch_array($rsDp3);
		
		// INSERT BERKAS
		$qInsertBerkas = "INSERT INTO berkas
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
					  	$_SESSION[id_pegawai],
					  	$_POST[id_kategori_berkas],
					  	'DP3',
					  	'-',
					  	CURDATE(),
					  	'0',
					  	'$tglDibuat',
					  	'-',
					  	'$_SESSION[nip_baru]',
					  	CURDATE()
					  )";
		
		$lastIdBerkas;
		//echo "INSERT BERKAS: $qInsertBerkas <br/>";
		if(mysqli_query($mysqli,$qInsertBerkas))
		{
			$lastIdBerkas = mysqli_insert_id();
		}
		
		// UPDATE id_berkas in DP3 table
		$qUpdateDp3 = "UPDATE dp3 SET id_berkas = $lastIdBerkas WHERE id = $_POST[id_dp3]";
		//echo "UPDATE ID BERKAS: $qUpdateSk <br/>";
		mysqli_query($mysqli,$qUpdateDp3);
					
		// UPLOAD FILE	
		$i = 0;
		//print_r($_FILES);
		foreach($_FILES as $f)
		{
			if($f[size] > 0)
			{
				$i++;		
				// INSERT DETAIL BERKAS	
				$qInsertDetail = "INSERT INTO isi_berkas (id_berkas, hal_ke, ket)
								  VALUES ($lastIdBerkas, $i, '-')";
				//echo ("<br/>$qInsertDetail");			
				$lastIdDetail;
				////echo "INSERT DETAIL BERKAS: $qInsertDetail <br/>";
				if(mysqli_query($mysqli,$qInsertDetail))
				{
					$lastIdDetail = mysqli_insert_id();
				}
				$path = addslashes("\\\\simpegserver\\htdocs\\simpeg\\Berkas\\");
				$fileName = "$_SESSION[nip_baru]-$lastIdBerkas-$lastIdDetail.jpg";
				//echo "FILE NAME: $fileName";
					
				//UPDATE filename in DETAIl BERKAS
				$qUpdateDetail = "UPDATE isi_berkas SET file_name = '".$path.$fileName."' WHERE id_isi_berkas = $lastIdDetail";
				//echo "UPDATE FILENAME: $qUpdateDetail <br/>";
				mysqli_query($mysqli,$qUpdateDetail);
				
				// UPLOAD FILE
				//echo "UPLOAD FILE: $f[file][tmp_name] ke Berkas/" . $fileName;
				move_uploaded_file($f[tmp_name], "Berkas/" . $fileName);
			}			
		}
	}
	
}
header("location:$_POST[fallback_url]")
?>