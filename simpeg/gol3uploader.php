<?php
include("konek.php");
$isi = scandir("gol3",1);
//print_r($isi);
for($i=0; $i<=sizeof($isi); $i++)
{
	$nip =  basename($isi[$i], ".pdf");
	
	if(strlen($nip)>10)
	{
	
	$qid=mysqli_query($mysqli,"select id_pegawai from pegawai where nip_baru='$nip'");
	$idp=mysqli_fetch_array($qid);
$qcek=mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$idp[0] and id_kat=39");
$cek=mysqli_fetch_array($qcek);
if($cek[0]==0)
{
 mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas) values ($idp[0],39,CURDATE(),1,CURDATE(),CURDATE(),'pupns')");
            $idarsip = mysqli_insert_id();
            mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
            $idisi = mysqli_insert_id();
            $namafile = "$nip-$idarsip-$idisi.pdf";
            mysqli_query($mysqli,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
            copy("pupns/$isi[$i]","Berkas/$namafile");
			echo("$isi[$i] copied <br>");
			
			
}
	}
	
}

?>