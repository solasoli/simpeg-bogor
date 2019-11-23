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
--- PER SKPD ---
<?php
$result_old = mysqli_query($mysqli,"SELECT nama, u.id_skpd, nama_skpd, nama_baru, COUNT(nama_baru) AS jumlah
FROM pegawai p
INNER JOIN current_lokasi_kerja c ON p.id_pegawai = c.id_pegawai
INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
INNER JOIN skpd on skpd.id_unit_kerja = u.id_skpd
where flag_pensiun = 0
GROUP BY u.id_skpd ORDER BY nama_skpd ASC");




$result = mysqli_query($mysqli,"SELECT nama, u.id_skpd, uk2.nama_baru as opd, COUNT(uk2.nama_baru) AS jumlah
FROM pegawai p
INNER JOIN current_lokasi_kerja c ON p.id_pegawai = c.id_pegawai
INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
inner join (select * from unit_kerja where id_unit_kerja = id_skpd) as uk2
	on uk2.id_unit_kerja = u.id_skpd
where flag_pensiun = 0
GROUP BY u.id_skpd ORDER BY uk2.nama_baru ASC");



?>
<a href="eksporskpd.php" target="_blank"> Export </a>
<table border="1">
<tr>
	<td style="background-color:blue"><font color="white">
		No
	</td>
	<td style="background-color:blue"><font color="white">
		id
	</td>
	<td style="background-color:blue"><font color="white">
		SKPD
	</td>
	<td style="background-color:blue"><font color="white">
		Jumlah
	</td>
</tr>

<?php $total = 0 ; $x=1 ; while($r = mysqli_fetch_array($result)): ?>
	<tr>
		<td> <?php echo $x++ ?></td>
		<td><?php echo $r['id_skpd'] ?></td>	
		<td>
			<?php echo $r['opd']; ?>&nbsp;
		</td>
		<td align="right">
			<?php echo $r['jumlah']; $total += $r['jumlah']?>
		</td>
	</tr>
<?php endwhile ?>
	<tr>
		<td></td>
		<td>TOTAL</td>
		<td><?php echo $total ?></td>
	</tr>
</table>
<br/>
<br/>
