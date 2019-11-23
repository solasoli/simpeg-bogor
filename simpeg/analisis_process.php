<br />
<br />
<br />
<?php
require("konek.php");
extract($_POST);

$query = 
"SELECT P.id_pegawai, P.nip_baru, P.nama, Pd.tingkat_pendidikan, Pd.jurusan_pendidikan
FROM pegawai P
INNER JOIN
(
  SELECT R.id_pegawai, R.id_unit_kerja
  FROM riwayat_mutasi_kerja R
  INNER JOIN
  (
    SELECT id_pegawai, max(id_riwayat) AS id_riwayat
    FROM riwayat_mutasi_kerja
    GROUP BY id_pegawai
  ) AS T ON R.id_riwayat = T.id_riwayat AND R.id_pegawai = T.id_pegawai
  WHERE id_unit_kerja = ".$id."
  ) AS R ON R.id_pegawai = P.id_pegawai
INNER JOIN
(
  SELECT Pd.id_pendidikan, Pd.id_pegawai, Pd.tingkat_pendidikan, Pd.jurusan_pendidikan
  FROM pendidikan Pd
  INNER JOIN
  (
    SELECT id_pegawai, min(level_p) AS level_p
    FROM pendidikan
    GROUP BY id_pegawai
  ) AS T ON Pd.id_pegawai = T.id_pegawai AND Pd.level_p = T.level_p
) AS Pd ON P.id_pegawai = Pd.id_pegawai
WHERE flag_pensiun = 0";

$result = mysql_query($query);
?>

<table align="center" cellpadding="5" border="1" style="border-collapse:collapse;">
<tr>
	<td>No.</td>
	<td>NIP</td>
	<td>Nama</td>
	<td>Tingkat Pendidikan</td>
	<td>Jurusan</td>
</tr>

<?php
$i=1;
while($r = mysql_fetch_array($result))
{
	?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo $r['nip_baru']; ?></td>
		<td><?php echo $r['nama']; ?></td>
		<td><?php echo $r['tingkat_pendidikan']; ?></td>
		<td><?php echo $r['jurusan_pendidikan']; ?></td>
	</tr>
	<?php
	$i++;
}
?>

</table>