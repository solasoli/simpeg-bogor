<?php
include("koncil.php");
extract($_GET);
$q=mysqli_query($con,"select file_name from isi_berkas where id_berkas=$id");
while($data=mysqli_fetch_array($q))
{
$nf=basename($data[0]);	
echo("<img src=../simpeg/Berkas/$nf ><br>");		
}

?>