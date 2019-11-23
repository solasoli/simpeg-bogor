<?php
extract($_POST);
if(@$radio!=NULL or @$lainnya!=NULL)
{	
    if(@$radio!=NULL)
	mysqli_query($mysqli,"update survey_pengkom set jenis_kompetensi_teknis='$radio' where id_pegawai=$idp");
	elseif(@$lainnya!=NULL)
	mysqli_query($mysqli,"update survey_pengkom set jenis_kompetensi_teknis='$lainnya' where id_pegawai=$idp");
	
	echo("<div align=center>Terima kasih sudah berpartisipasi dalam survey ini </div>");
}

if(@$radio2!=NULL)
{
	mysqli_query($mysqli,"update survey_pengkom set tempat_magang_manajerial='$radio2' where id_pegawai=$idp");
	echo("<div align=center>Terima kasih sudah berpartisipasi dalam survey ini </div>");
}

?>