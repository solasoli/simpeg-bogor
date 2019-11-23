<?php
include 'konek.php';

//print_r($_FILES);
print_r($_POST);

if($_FILES['fija']){
	
	$tu=date("Y-m-d");
	$tc=date("Y-m-d h:i:s");
	$tmp = $_FILES['fija']['tmp_name'];
	//echo "select nip_baru from pegawai where id_pegawai=".$_POST['idp'];
	$qp = mysqli_query($mysqli,"select nip_baru from pegawai where id_pegawai=".$_POST['idp']);
	$pega = mysqli_fetch_array($qp);


	$sql = mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas) values (".$_POST['idp'].",3,'$tu',1,'$tu','$tc','Ijazah')");

	$idarsip = mysqli_insert_id();
	mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
	$idisi = mysqli_insert_id();
    mysqli_query($mysqli,"update pendidikan set id_berkas=$idarsip where id_pendidikan=$_POST[idpen]");

	if($_FILES['fija']['type']=='image/jpeg' or $_FILES['fija']['type']=='image/jpg')
$tipe="jpg";
else if($_FILES['fija']['type']=='binary/octet-stream' or $_FILES['fija']['type']=='application/pdf')
$tipe="pdf";
	
	
	$namafile="$pega[0]-$idarsip-$idisi.$tipe";
	
	//echo "update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi";
	mysqli_query($mysqli,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
	
	move_uploaded_file($tmp, "../simpeg/Berkas/$namafile");

			
	if(mysqli_query($mysqli,$sql)){
		echo "1";		
	}else{
		echo "0";
	}
	
}else{
	echo "tidak ada post";
}
