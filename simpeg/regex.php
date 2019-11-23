<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from satya where nip not like '1%' and nip not like '2%'");
while ($data=mysqli_fetch_array($q))
{


$string = $data[1];

$new_string = ereg_replace("[^0-9]", "", $string);

mysqli_query($mysqli,"update satya set nip='$new_string' where id=$data[0]");


}

echo("done");
?>