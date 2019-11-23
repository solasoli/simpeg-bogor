<?php
include("konek.php");
$isi = scandir("pupns",1);
print_r($isi);

for($i=0; $i<=sizeof($isi); $i++)
{
	$nip =  basename($isi[$i], ".pdf");
	
	if(strlen($nip)>10)
	{
	
	$qid=mysql_query("select id_pegawai from pegawai where nip_baru='$nip'");
	$idp=mysql_fetch_array($qid);
$qcek=mysql_query("select count(*) from berkas where id_pegawai=$idp[0] and id_kat=39");
$cek=mysql_fetch_array($qcek);
if($cek[0]==0)
{
 mysql_query("insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas) values ($idp[0],39,CURDATE(),1,CURDATE(),CURDATE(),'pupns')");
            $idarsip = mysql_insert_id();
            mysql_query("insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
            $idisi = mysql_insert_id();
            $namafile = "$nip-$idarsip-$idisi.pdf";
            mysql_query("update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
            copy("pupns/$isi[$i]","Berkas/$namafile");
			echo("$isi[$i] copied <br>");
			
			
}
	}
	
}

?>