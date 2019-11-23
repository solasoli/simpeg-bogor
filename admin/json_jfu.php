<?php
include("koncil.php");
extract($_GET);
$k=mysql_query("SELECT id_jfu, nama_jfu as jabatan, kode_jabatan
                FROM jfu_master WHERE nama_jfu like '%$q%' ORDER BY nama_jfu");

while($ata=mysql_fetch_array($k))
{

    $data[] = array(
        'label' => $ata[1],
        'value' =>$ata[0],
        'kode_jabatan' => $ata[2]
    );

}
echo json_encode($data);
?>
