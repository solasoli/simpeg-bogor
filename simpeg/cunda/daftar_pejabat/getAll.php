<?php
	require_once("../../konek.php");
	$q = mysql_query("SELECT NAMA AS Nama, nip_baru AS 'NIP_Baru', nip_lama AS 'NIP_Lama', jabatan.jabatan AS Jabatan, P.tingkat_pendidikan AS 'Jenjang_Pendidikan'
					FROM jabatan
					INNER JOIN pegawai ON pegawai.id_j = jabatan.id_j
					INNER JOIN  pendidikan ON pendidikan.id_pegawai = pegawai.id_pegawai
					INNER JOIN
					(
					  SELECT P.id_pegawai, tingkat_pendidikan, jurusan_pendidikan, tahun_lulus, min_level
					  FROM pendidikan P
					  INNER JOIN
					  (
						SELECT id_pegawai, MIN(level_p) AS min_level
						FROM pendidikan
						GROUP BY id_pegawai
					  ) AS T
					  ON T.id_pegawai = P.id_pegawai AND
					  T.min_level = P.level_p
					) AS P
					ON P.id_pegawai = pegawai.id_pegawai
					GROUP BY pegawai.id_pegawai
					ORDER BY min(level_p)");
					
	echo "<table style='
						border-collapse: collapse;
						' 		
				border='1'>
		  <tr style='font-weight: bold; text-align:center; padding: 10 10 10 10;'>
			<td>
				Nomor
			</td>
			<td>
				Nama
			</td>
			<td>
				NIP Baru
			</td>
			<td>
				NIP Lama
			</td>
			<td>
				Jabatan
			</td>
			<td>
				Jenjang Pendidikan
			</td>
		  </tr>";
	$i = 1;
	while($r = mysql_fetch_array($q))
	{
		echo "<tr>
				<td style='text-align:right; vertical-align:top'>
					$i
				</td>
				<td style='vertical-align:top'>
					$r[Nama] &nbsp;
				</td>
				<td style='vertical-align:top'>
					$r[NIP_Baru] &nbsp;
				</td>
				<td style='vertical-align:top'>
					$r[NIP_Lama] &nbsp;
				</td>
				<td style='vertical-align:top'>
					$r[Jabatan] &nbsp;
				</td>
				<td style='vertical-align:top'>
					$r[Jenjang_Pendidikan] &nbsp;
				</td>
			</tr>";
			$i++;
	}
	echo "</table>";
?>