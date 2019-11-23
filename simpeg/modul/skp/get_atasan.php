<?php

require_once("../../konek.php");
require_once("../../class/pegawai.php");

extract($_GET);
$sql = "SELECT jm.id_jfu, jm.kode_jabatan, jm.nama_jfu FROM jfu_master jm 
		WHERE jm.nama_jfu like '%$q%'
		ORDER BY jm.nama_jfu";
		
		
$sql = "select pegawai.id_pegawai, pegawai.nama from pegawai where nama like '%$q%'";
$k=mysql_query($sql);
//echo $sql."<br>";
//echo "id_skpd".$skpd."::q=".$q;
while($ata=mysql_fetch_array($k))
{
$data[] = array(
	'id_pegawai' => $ata[0], 
	'nama' =>$ata[1]
);

}
echo json_encode($data);