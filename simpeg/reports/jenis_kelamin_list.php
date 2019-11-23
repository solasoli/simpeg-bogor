<?php
include_once "../konek.php";
include_once "../lib/PegawaiRepository.php"
?>
<table border="1" style="border-collapse: collapse" width="100%">
<tr>
	<th rowspan="2">No</th>
	<th rowspan="2">Unit Kerja</th>
	<th colspan="2">Jenis Kelamin</th>
	<th rowspan="2">Jumlah</th>	
</tr>
<tr>
	<th>L</th>
	<th>P</th>
</tr>

<?php
$q = "SELECT id_unit_kerja, nama_baru
	  FROM unit_kerja u
	  WHERE u.tahun = '".date("Y")."'
	  ORDER BY u.nama_baru";
$rsUnitKerja = mysql_query($q);

//counter
$i = 1;
$Ltotal = 0;
$PTotal = 0;
?>
<?php while($rUnitKerja = mysql_fetch_array($rsUnitKerja)): ?>
<?php
	$L = countPegawaiBySkpdAndGender($rUnitKerja['id_unit_kerja'], 'L');
	$P = countPegawaiBySkpdAndGender($rUnitKerja['id_unit_kerja'], 'P');
	$Ltotal += $L;
	$Ptotal += $P;
?>
	<tr>
		<td class="number"><?php echo $i; ?></td>
		<td><?php echo $rUnitKerja['nama_baru']; ?></td>
		<td class="number"><?php echo $L; ?></td>
		<td class="number"><?php echo $P; ?></td>
		<td class="number"><?php echo ($L + $P); ?></td>
	</tr>
<?php $i++; ?>
<?php endwhile; ?>
<tr>
	<th colspan="2" >
		<strong>JUMLAH</strong>
	</th>
	<th class="number"><?php echo $Ltotal; ?></th>
	<th class="number"><?php echo $Ptotal; ?></th>
	<th class="number"><?php echo ($Ptotal + $Ltotal); ?></th>
</tr>
</table>