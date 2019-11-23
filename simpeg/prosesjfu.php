<?php 
include("konek.php");
extract($_GET);
$sql = "SELECT jm.id_jfu, jm.kode_jabatan, jm.nama_jfu FROM jfu_master jm 
		WHERE jm.nama_jfu like '%$q%'
		ORDER BY jm.nama_jfu";
$k=mysqli_query($mysqli,$sql);
//echo $sql."<br>";
//echo "id_skpd".$skpd."::q=".$q;
while($ata=mysqli_fetch_array($k))
{
$data[] = array(
'id_jfu' => $ata[0], 
'kode_jabatan' =>$ata[1],
'nama_jfu' => $ata[2]
);

}
echo json_encode($data);
?>

