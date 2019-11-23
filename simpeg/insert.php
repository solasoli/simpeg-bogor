<?

include("konek.php");



$q=mysqli_query($mysqli,"select * from temp2 ");

while($data=mysqli_fetch_array($q))

{

$q2=mysqli_query($mysqli,"select nip_lama from pegawai where nip_baru=$data[0]");

$ata=mysqli_fetch_array($q2);

mysqli_query($mysqli,"update temp2 set niplama='$ata[0]' where nip='$data[0]'");











}

echo("done");

?>