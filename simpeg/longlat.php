<?php
include("konek.php");
$q=mysqli_query($mysqli,"select x(long_lat),nama_baru from unit_kerja where tahun=2015");
while($data=mysqli_fetch_array($q))
{
echo ("$data[1] $data[0] <br>");

}
?>