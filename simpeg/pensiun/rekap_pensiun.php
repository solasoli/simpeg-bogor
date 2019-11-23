<?php
extract($_POST);
include_once "../konek.php";

$q = "SELECT tgl_lahir, 
		DATE_ADD(DATE_ADD(tgl_lahir, INTERVAL 56 YEAR ), INTERVAL 1 MONTH) AS 'tmt_pensiun',  		
		DATE_FORMAT(DATE_ADD(DATE_ADD(tgl_lahir, INTERVAL 56 YEAR ), INTERVAL 1 MONTH), '%Y') AS 'tahun_pensiun',
		DATE_FORMAT(DATE_ADD(DATE_ADD(tgl_lahir, INTERVAL 56 YEAR ), INTERVAL 1 MONTH), '%m') AS 'bulan_pensiun' 
	  FROM pegawai p
	  WHERE 
		DATE_FORMAT(DATE_ADD(DATE_ADD(tgl_lahir, INTERVAL 56 YEAR ), INTERVAL 1 MONTH), '%Y') = $tahun
		AND p.jenjab LIKE '%struktural%'";

$rs = mysql_query($q);
$i = 1;
while($r = mysql_fetch_array($rs))
{
	echo "$i. "; print_r($r); echo "<br/>";
	$i++;
}

?>
<table border="1">
<tr>
	<td rowspan="2" >No</td>
	<td rowspan="2" >Eselon</td>
	<td colspan="12">Bulan</td>
	<td rowspan="2" >Jumlah</td>
</tr>
<tr>
	<td>Jan</td>
	<td>Feb</td>
	<td>Mar</td>
	<td>Apr</td>
	<td>Mei</td>
	<td>Jun</td>
	<td>Jul</td>
	<td>Ags</td>
	<td>Sept</td>
	<td>Okt</td>
	<td>Nov</td>
	<td>Des</td>
</tr>
<tr>
	<td colspan="2">JUMLAH</td>
	<td>[Jan]</td>
	<td>[Feb]</td>
	<td>[Mar]</td>
	<td>[Apr]</td>
	<td>[Mei]</td>
	<td>[Jun]</td>
	<td>[Jul]</td>
	<td>[Ags]</td>
	<td>[Sept]</td>
	<td>[Okt]</td>
	<td>[Nov]</td>
	<td>[Des]</td>
	<td>[JUMLAH]</td>
</tr>
</table>