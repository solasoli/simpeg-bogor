<?php
include_once "konek.php";


function getCurrentUnitKerja($id_pegawai)
{
	$q = "SELECT * FROM current_lokasi_kerja c INNER JOIN unit_kerja u ON c.id_unit_kerja = u.id_unit_kerja
		  WHERE id_pegawai = $id_pegawai";
		  
	$rs = mysqli_query($mysqli,$q);

	$unit_kerja = mysqli_fetch_array($rs);

	return $unit_kerja;
}
?>