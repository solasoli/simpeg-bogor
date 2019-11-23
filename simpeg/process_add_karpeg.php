<?php
session_start();
require "konek.php";
if(!$_POST[upload_only])
{
	$tmtSk = substr($_POST[tmt_sk], 6, 4)."-".substr($_POST[tmt_sk], 3, 2)."-".substr($_POST[tmt_sk], 0, 2);
	$tglSk = substr($_POST[tgl_sk], 6, 4)."-".substr($_POST[tgl_sk], 3, 2)."-".substr($_POST[tgl_sk], 0, 2); 
	
	$qUpdateKarpeg = "UPDATE pegawai SET no_karpeg = '$_POST[karpeg]' WHERE id_pegawai = $_SESSION[id_pegawai]";
					
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
					  	'$_POST[nm_berkas]',
					  	'-',
					  	CURDATE(),
					  	'0',
					  	CURDATE(),
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
				////echo "Image type invalid.";
				$isValid = false;
				return;
			}			
	}			
	
	if($isValid)
	{
		// UPDATE NO KARPEG IN pegawai
		$lastIdSk;
		////echo "INSERT SK: $qInsertSk <br/>";
		if(mysqli_query($mysqli,$qUpdateKarpeg))
		{
			$lastIdSk = mysqli_insert_id();
		}
			
		// INSERT BERKAS
		$lastIdBerkas;
		////echo "INSERT BERKAS: $qInsertBerkas <br/>";
		if(mysqli_query($mysqli,$qInsertBerkas))
		{
			$lastIdBerkas = mysqli_insert_id();
		}
		
		// UPDATE id_berkas in SK table
		//$qUpdateSk = "UPDATE sk SET id_berkas = $lastIdBerkas WHERE id_sk = $lastIdSk";
		//echo "UPDATE ID BERKAS: $qUpdateSk <br/>";
		//mysqli_query($mysqli,$qUpdateSk);
		
		
			
		// UPLOAD FILE	
		$i = 1;
		foreach($_FILES as $f)
		{
			if($f[size] > 0)
			{		
				// INSERT DETAIL BERKAS	
				$qInsertDetail = "INSERT INTO isi_berkas (id_berkas, hal_ke)
								  VALUES ($lastIdBerkas, $i)";
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
		}						
	}
}
else 
	
	
// UPDATE FILE DOANG	
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
		//$qSk = "SELECT tgl_sk FROM sk WHERE id_sk = $_POST[id_sk]";
		//$rsSk = mysqli_query($mysqli,$qSk);
		//$rSk = mysqli_fetch_array($rsSk);
		
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
					  	'$_POST[nm_berkas]',
					  	'-',
					  	CURDATE(),
					  	'0',
					  	CURDATE(),
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
		
		// UPDATE id_berkas in SK table
		//$qUpdateSk = "UPDATE sk SET id_berkas = $lastIdBerkas WHERE id_sk = $_POST[id_sk]";
		//echo "UPDATE ID BERKAS: $qUpdateSk <br/>";
		//mysqli_query($mysqli,$qUpdateSk);
		
		
			
		// UPLOAD FILE	
		$i = 1;
		foreach($_FILES as $f)
		{
			if($f[size] > 0)
			{		
				// INSERT DETAIL BERKAS	
				$qInsertDetail = "INSERT INTO isi_berkas (id_berkas, hal_ke)
								  VALUES ($lastIdBerkas, $i)";
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
		}
	}
}
header("location:$_POST[fallback_url]");
?>