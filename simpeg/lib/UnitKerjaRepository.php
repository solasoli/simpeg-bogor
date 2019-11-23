<?php

if(file_exists("konek.php"))
	include_once "konek.php";

function getAllCurrentSKPD(){
	$q = "SELECT * 
		  FROM unit_kerja u
		  WHERE tahun = ( SELECT MAX(tahun) FROM unit_kerja )";
		  
	$q = mysql_query($q);
	
	if(mysql_num_rows($q) > 0)
	{
		return $q;
	}
	else
	{
		return '';	
	}
}

?>