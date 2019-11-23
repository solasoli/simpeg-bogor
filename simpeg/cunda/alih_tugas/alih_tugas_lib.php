<?php
function getUnitKerja()
{
	$q = "SELECT id_unit_kerja, nama_baru FROM unit_kerja ORDER BY nama_baru ASC";
	return mysql_query($q);
}
?>