<?php
include "../konek.php";

$q = "SELECT s.id_pegawai, s.id_sk, s.id_kategori_sk, s.id_berkas, s.no_sk, s.tmt, t.total
FROM sk s
INNER JOIN (

SELECT id_pegawai, no_sk, tmt, total
FROM (

SELECT id_pegawai, no_sk, tmt, COUNT( * ) AS total
FROM sk
GROUP BY id_pegawai, no_sk, tmt
ORDER BY  `total` DESC
) AS t
WHERE t.total >1
AND no_sk !=  '-'
ORDER BY total DESC
) AS t ON t.id_pegawai = s.id_pegawai
AND s.no_sk = t.no_sk
AND s.tmt = t.tmt
WHERE s.id_berkas IS NULL 
OR s.id_berkas =  ''
LIMIT 0 , 30";

$rs = mysql_query($q);
while($r = mysql_fetch_array($rs))
{
	$qCurrent = "SELECT id_sk
				 FROM sk 
				 WHERE no_sk = '$r[no_sk]' AND tmt = '$r[tmt]' AND id_pegawai = '$r[id_pegawai]'";
	echo $qCurrent."<br/>";
	$rsCurrent = mysql_query($qCurrent);
	$numrows = mysql_num_rows($rsCurrent);
	for($i = 0; $i < $numrows-1; $i++)
	{
		$rCurrent = mysql_fetch_array($rsCurrent);
		echo $rCurrent[id_sk]."<br/>";	
		mysql_query("DELETE FROM sk WHERE id_sk = $rCurrent[id_sk]");
	}
}

?>