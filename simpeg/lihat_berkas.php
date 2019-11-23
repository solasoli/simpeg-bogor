<?php
include("konek.php");
extract($_GET);
$q=mysqli_query($mysqli,"select file_name from isi_berkas where id_berkas=$id");
while($data=mysqli_fetch_array($q))
{
$nf=basename($data[0]);
$bom=explode(".",$nf);	
if($bom[1]=='jpg' or $bom[2]=='png')
echo("<img src=../simpeg/Berkas/$nf >");
else
echo("<a href=./Berkas/$nf target=blank>Download </a>");		
}

?>