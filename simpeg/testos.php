<?

include("konek.php");

$q=mysqli_query($mysqli,"select * from pegawai where id_pegawai<12");



while($data=mysqli_fetch_array($q))

echo($data['nama']);



?>