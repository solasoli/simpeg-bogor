<?php
include("koncil.php");
extract($_GET);
$k=mysqli_query($con,"SELECT id, instansi
                FROM instansi WHERE instansi like '%$q%' ORDER BY instansi");

while($ata=mysqli_fetch_array($k))
{

    $data[] = array(
        'label' => $ata[1],
        'value' =>$ata[0]

    );

}
echo json_encode($data);
?>

