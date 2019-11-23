<?php

	//baca lokasi file sementara dan nama file dari form(fupload)
	/*$lokasi_file = $_FILES['fupload']['tmp_name'];
	$nama_file   = $_FILES['fupload']['name'];
	
	//tentukan folder untuk menyimpan file
	$folder = '/files_cuti/'.$nama_file;	
	$tgl_upload = date("Ymd"); //tanggal sekarang
	
	//apabila fle berhasil dupload
	if(move_uploaded_file($lokasi_file, "$folder")){
	echo "Nama File : <b>$nama_file</b> sukses di upload";*/
	
	session_start();
	$lokasi_file = $_FILES['foto']['tmp_name'];
	$nama_file = $_FILES['foto']['name'];
	$folder = 'files_cuti/'.$nama_file;
	
	$tgl_upload = date("Ymd"); //tanggal sekarang
	
	if(move_uploaded_file($lokasi_file,"$folder"))
	{
	echo "Nama File : <b>$folder</b> sukses di upload";
	
	//masukkan informasi file ke database
	mysqli_connect("simpeg.db.kotabogor.net","simpeg","Madangkara2017");
	
	mysqli_select_db("simpeg");
	
	$query1 = "SELECT max(id_cuti_pegawai) as max FROM cuti_pegawai WHERE id_pegawai=".$_SESSION['id_pegawai'];
	$hasil1 = mysqli_query($mysqli,$query1);
	
	$data_cuti = mysqli_fetch_array($hasil1);
	$id_max_cuti = $data_cuti['max'];
	
	$query = "UPDATE cuti_pegawai SET berkas='".$folder."' WHERE id_pegawai=".$_SESSION['id_pegawai']." AND id_cuti_pegawai=".$id_max_cuti;
	$hasil = mysqli_query($mysqli,$query);
	}
		//$id_cuti_pegawai = $_GET['id_cuti_pegawai'];
		
		//$nama_file_0 = $id_cuti_pegawai;
		
		//$nama_file_0 = get_file_type($_FILES['fupload']['type'][0] );
								
		//$_FILES['fupload']['name'][0] = $nama_file_0;

		//$path0= "assets/surat_cuti".$_FILES['fupload']['name'][0];
			
			//copy($_FILES['fupload']['tmp_name'][0], $path0);
		
	
	function get_file_type($input)
		{
			switch($input)
			{
				case  "image/png" :
					  return ".png";
				case  "image/jpg" :
					  return ".jpg";
				case  "image/jpeg" :
					  return ".jpeg";
				case  "image/gif" :
					  return ".gif";
				case  "application/pdf" :
					  return ".pdf";
			}	
		}
?>
