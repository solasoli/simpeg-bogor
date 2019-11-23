<?php
	include "connection.php";
	
	$q = "SELECT nama_baru AS 'Unit Kerja', jenis_kelamin AS 'Jenis Kelamin', COUNT(*) AS Jumlah
	FROM
	(
	SELECT peg.id_pegawai, nama_baru, jenis_kelamin
	FROM pegawai peg
	INNER JOIN
	(
		SELECT riwayat1.id_pegawai AS idp, nama_baru
		FROM riwayat_mutasi_kerja riwayat1
		INNER JOIN
		(
			SELECT riwayat_mutasi_kerja.id_pegawai, MAX(id_riwayat) AS id_riwayat
			FROM riwayat_mutasi_kerja
			GROUP BY id_riwayat
		) AS riwayat2
			ON riwayat1.id_pegawai = riwayat2.id_pegawai 
			AND riwayat1.id_riwayat = riwayat2.id_riwayat
		INNER JOIN unit_kerja unit
			ON riwayat1.id_unit_kerja = unit.id_unit_kerja
			
	) AS riwayat
	ON peg.id_pegawai = riwayat.idp
	WHERE peg.flag_pensiun = 0
	GROUP BY peg.id_pegawai
	) AS  final
	GROUP BY nama_baru, jenis_kelamin
	ORDER BY nama_baru";
	
	$i = 1;
?>

<div style ="font-family: arial">

<b>
	LAMPIRAN : <br />
	3. Rekapitulasi PNS/CPNS Berdasarkan Jenis Kelamin
</b>

<h2>
	<CENTER>
	REKAPITULASI PNS/CPNS BERDASARKAN JENIS KELAMIN <br />
	KOTA BOGOR <br />
	PER 31 DESEMBER 2010 <br />
	</CENTER>
</h2>

<table width="100%" border="1">
	<tr style="font-weight: bold">
		<td align="center">NO.&nbsp;</td>
		<td align="center">UNIT KERJA&nbsp;</td>
		<td align="center">LAKI-LAKI&nbsp;</td>
		<td align="center">PEREMPUAN&nbsp;</td>
		<td align="center">JUMLAH&nbsp;</td>
	</tr>

<?php
	$rs = mysql_query($q);
	$prev;
	$LTotal = 0;
	$PTotal = 0;
	while($r = mysql_fetch_array($rs))
	{
		$prev = $r;
		$L = 0;
		$P = 0;
		
		if($prev["Jenis Kelamin"] == 'L')
			$L = $prev["Jumlah"];
		else if($prev["Jenis Kelamin"] == 'P')
			$P = $prev["Jumlah"];
		
		if($r = mysql_fetch_array($rs))
		{
			if($prev["Unit Kerja"] != $r["Unit Kerja"])
			{
			?>
				<tr>
					<td>&nbsp;<?php echo $i; ?></td>
					<td>&nbsp;<?php echo $prev['Unit Kerja']; ?></td>
					<td>&nbsp;<?php echo $L; ?></td>
					<td>&nbsp;<?php echo $P; ?></td>
					<td>&nbsp;<?php echo $L + $P; ?></td>
				</tr>
			<?php
			}
			else
			{
				if($r["Jenis Kelamin"] == 'L')
					$L = $r["Jumlah"];
				else if($r["Jenis Kelamin"] == 'P')
					$P = $r["Jumlah"];
					
				?>
				<tr>
					<td>&nbsp;<?php echo $i; ?></td>
					<td>&nbsp;<?php echo $r['Unit Kerja']; ?></td>
					<td>&nbsp;<?php echo $L; ?></td>
					<td>&nbsp;<?php echo $P; ?></td>
					<td>&nbsp;<?php echo $L + $P; ?></td>
				</tr>	
				<?php
			}
			
			$LTotal += $L;
			$PTotal += $P;

			$prev = $r;
		}
	?>
	
	<?php
	$i++;
	}
?>


	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td style="font-weight: bold" align="center">&nbsp;TOTAL</td>
		<td>&nbsp;<?php echo $LTotal; ?></td>
		<td>&nbsp;<?php echo $PTotal; ?></td>
		<td>&nbsp;<?php echo $LTotal + $PTotal; ?></td>
	</tr>

</table>

<?php


	
?>

</div>
