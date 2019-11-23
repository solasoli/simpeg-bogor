<?php
include("koncil.php");
extract($_GET);
$k=mysqli_query($con, "SELECT id_jafung, concat(nama_jafung,' ',jenjang_jabatan) as jabatan
                FROM jafung WHERE nama_jafung like '%$q%' ORDER BY nama_jafung, tingkat, pangkat_gol");

while($ata=mysqli_fetch_array($k))
{

    $data[] = array(
        'label' => $ata[1],
        'value' =>$ata[0]

    );

}
echo json_encode($data);
?>
