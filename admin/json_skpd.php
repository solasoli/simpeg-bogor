<?php 
include("koncil.php");
extract($_GET);
$k=mysqli_query($con,"SELECT id_unit_kerja, nama_baru
                FROM unit_kerja uk WHERE uk.tahun = (SELECT MAX(tahun) FROM unit_kerja)
                AND nama_baru like '%$q%' ORDER BY uk.nama_baru");
				
while($ata=mysqli_fetch_array($k))
{

$data[] = array(
'label' => $ata[1],
'value' =>$ata[0]

);

}
echo json_encode($data);
?>

