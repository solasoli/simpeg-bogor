<?php

require_once("../../konek.php");


$term = $_GET['term'];

/* $sql = "SELECT id_unit_kerja as id, concat(nama_baru, " (",tahun,") ") as value, nama_baru as nama
		FROM unit_kerja
		WHERE nama_baru LIKE '%$term%'";
*/
$sql = "SELECT id_unit_kerja as id, nama_baru as value, nama_baru as nama
		FROM unit_kerja
		WHERE nama_baru LIKE '%$term%'
		and (tahun like '2017')
		order by tahun DESC
		";

$result = mysqli_query($mysqli,$sql);

while($row = mysqli_fetch_array($result)){

	$row_set[] = $row;

}

echo json_encode($row_set);
