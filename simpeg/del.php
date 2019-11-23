<?

$final=$_REQUEST['final'];

$idn=$_REQUEST['idn'];

$u=$_REQUEST['u'];

include("konek.php");

mysqli_query($mysqli,"update pegawai set id_next=0 where id_pegawai=$idn");

include("rf.php");

?>