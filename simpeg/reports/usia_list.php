<?php
include_once "../konek.php";
include_once "../lib/PegawaiRepository.php"
?>
<table border="1" style="border-collapse: collapse" width="100%">
<tr>
	<th rowspan="2">No</th>
	<th rowspan="2">Unit Kerja</th>
	<th colspan="10">Kelompok Usia</th>
</tr>
<tr>
  <th><=25</th>
  <th>26-30</th>
  <th>31-35</th>
  <th>36-40</th>
  <th>41-45</th>
  <th>46-50</th>
  <th>51-55</th>
  <th>56-60</th>
  <th>>=61</th>
  <th>Jumlah</th>
</tr>
<?php
$q = "SELECT id_unit_kerja, nama_baru
	  FROM unit_kerja u
	  WHERE u.tahun = '".date("Y")."'
	  ORDER BY u.nama_baru";
$rsUnitKerja = mysql_query($q);

//counter
$counter = 1;
$a = 0;
$b = 0;
$c = 0;
$d = 0;
$e = 0;
$f = 0;
$g = 0;
$h = 0;
$i = 0;
$aTotal = 0;
$bTotal = 0;
$cTotal = 0;
$dTotal = 0;
$eTotal = 0;
$fTotal = 0;
$gTotal = 0;
$hTotal = 0;
$iTotal = 0;
?>
<?php while($rUnitKerja = mysql_fetch_array($rsUnitKerja)): ?>
<?php 
  $a = countPegawaiBySkpdAndUsiaBelow($rUnitKerja['id_unit_kerja'], 26);
  $aTotal += $a;
  
  $b = countPegawaiBySkpdAndUsiaBetween($rUnitKerja['id_unit_kerja'], 26, 30);
  $bTotal += $b;
  
  $c = countPegawaiBySkpdAndUsiaBetween($rUnitKerja['id_unit_kerja'], 31, 35);
  $cTotal += $c;
  
  $d = countPegawaiBySkpdAndUsiaBetween($rUnitKerja['id_unit_kerja'], 36, 40);
  $dTotal += $d;
  
  $e = countPegawaiBySkpdAndUsiaBetween($rUnitKerja['id_unit_kerja'], 41, 45);
  $eTotal += $e;
  
  $f = countPegawaiBySkpdAndUsiaBetween($rUnitKerja['id_unit_kerja'], 46, 50);
  $fTotal += $f;
  
  $g = countPegawaiBySkpdAndUsiaBetween($rUnitKerja['id_unit_kerja'], 51, 55);
  $gTotal += $g;
  
  $h = countPegawaiBySkpdAndUsiaBetween($rUnitKerja['id_unit_kerja'], 56, 60);
  $hTotal += $h;
  
  $i = countPegawaiBySkpdAndUsiaGreater($rUnitKerja['id_unit_kerja'], 60);
  $iTotal += $i;
?>
	<tr>
		<td class="number"><?php echo $counter; ?></td>
		<td><?php echo $rUnitKerja['nama_baru']; ?></td>
		<td class="number"><?php echo $a; ?></th>
    <td class="number"><?php echo $b; ?></td>
    <td class="number"><?php echo $c; ?></td>
    <td class="number"><?php echo $d; ?></td>
    <td class="number"><?php echo $e; ?></td>
    <td class="number"><?php echo $f; ?></td>
    <td class="number"><?php echo $g; ?></td>
    <td class="number"><?php echo $h; ?></td>
    <td class="number"><?php echo $i; ?></td>
    <td class="number"><?php echo $a + $b + $c + $d + $e + $f + $g + $h + $i; ?></td>
	</tr>
<?php $counter++; ?>
<?php endwhile; ?>
<tr>
	<th colspan="2" >
		<strong>JUMLAH</strong>
	</th>
  <th class="number"><?php echo $aTotal; ?></th>
	<th class="number"><?php echo $bTotal; ?></th>
  <th class="number"><?php echo $cTotal; ?></th>
  <th class="number"><?php echo $dTotal; ?></th>
  <th class="number"><?php echo $eTotal; ?></th>
  <th class="number"><?php echo $fTotal; ?></th>
  <th class="number"><?php echo $gTotal; ?></th>
  <th class="number"><?php echo $hTotal; ?></th>
  <th class="number"><?php echo $iTotal; ?></th>
  <th class="number"><?php echo $aTotal + $bTotal + $cTotal + $dTotal + $eTotal + $fTotal + $gTotal + $hTotal + $iTotal; ?></th>
</tr>
</table>