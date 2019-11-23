<?php require_once("konek.php"); ?>

<script type="text/javascript" src="lib/js/jquery-ui-1.8.2.custom.min"></script>
<b> Rekapitulasi Data Pegawai PNS Kota Bogor Per <?php echo date('F Y');?> </b>
<br/>
<br/>
--- PEGAWAI ---
<?php
$result = mysqli_query($mysqli,"SELECT id_pegawai,COUNT(id_pegawai) AS jumlah FROM pegawai
where flag_pensiun =0");
?>
<table border="1">
<tr>
	<td style="background-color:blue"><font color="white">
		Jumlah Pegawai
	</td>
</tr>

<?php while($r = mysqli_fetch_array($result)): ?>
	<tr>
		<td align="center">
			<?php echo $r['jumlah']; ?>&nbsp;
		</td>
	</tr>
<?php endwhile ?>
</table>
<br/>
<br/>
--- PER SKPD Lengkap---
<?php
$result = mysqli_query($mysqli,"SELECT nama_skpd, COUNT(nama_skpd) AS jumlah
FROM pegawai p
INNER JOIN current_lokasi_kerja c ON p.id_pegawai = c.id_pegawai
INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
GROUP BY s.id_unit_kerja ORDER BY  s.skpd ASC ");
?>
<a href="eksporskpd.php" target="_blank"> Export </a>
<table border="1">
<tr>
	<td style="background-color:blue"><font color="white">
		SKPD
	</td>
	<td style="background-color:blue"><font color="white">
		Jumlah
	</td>
</tr>

<?php while($r = mysqli_fetch_array($result)): ?>
	<tr>
		<td>
			<?php echo $r['nama_skpd']; ?>&nbsp;
		</td>
		<td align="right">
			<?php echo $r['jumlah']; ?>&nbsp;
		</td>
	</tr>
<?php endwhile ?>
</table>
<br/>
<br/>
