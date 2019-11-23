<?php
include_once "../konek.php";
include_once "../lib/PegawaiRepository.php"
?>
<table border="1" style="border-collapse: collapse" width="100%">
<tr>
	<th rowspan="3">No</th>
	<th rowspan="3">Unit Kerja</th>
	<th colspan="21">Golongan</th>
	<th rowspan="3">Jumlah</th>	
</tr>
<tr>
	<th colspan="6">IV</th>
	<th colspan="5">III</th>
  <th colspan="5">II</th>
  <th colspan="5">I</th>
</tr>
<tr>
	<th>A</th>
  <th>B</th>
  <th>C</th>
  <th>D</th>
  <th>E</th>
  <th>JML</th>
  
  <th>A</th>
  <th>B</th>
  <th>C</th>
  <th>D</th>
  <th>JML</th>
  
  <th>A</th>
  <th>B</th>
  <th>C</th>
  <th>D</th>
  <th>JML</th>
  
  <th>A</th>
  <th>B</th>
  <th>C</th>
  <th>D</th>
  <th>JML</th>
</tr>

<?php
$q = "SELECT id_unit_kerja, nama_baru
	  FROM unit_kerja u
	  WHERE u.tahun = '".date("Y")."'
	  ORDER BY u.nama_baru";
$rsUnitKerja = mysql_query($q);

//counter
$i = 1;
$ivaTotal = 0;
$ivbTotal = 0;
$ivcTotal = 0;
$ivdTotal = 0;
$iveTotal = 0;

$iiiaTotal = 0;
$iiibTotal = 0;
$iiicTotal = 0;
$iiidTotal = 0;

$iiaTotal = 0;
$iibTotal = 0;
$iicTotal = 0;
$iidTotal = 0;

$iaTotal = 0;
$ibTotal = 0;
$icTotal = 0;
$idTotal = 0;
?>
<?php while($rUnitKerja = mysql_fetch_array($rsUnitKerja)): ?>
<?php
	$iva = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'IV/a');
  $ivaTotal += $iva;  
  $ivb = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'IV/b');
  $ivbTotal += $ivb;
  $ivc = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'IV/c');
  $ivcTotal += $ivc;
  $ivd = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'IV/d');
  $ivdTotal += $ivd;
  $ive = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'IV/e');
  $iveTotal += $ive;
  
  $iiia = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'III/a');
  $iiiaTotal += $iiia;
  $iiib = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'III/b');
  $iiibTotal += $iiib;
  $iiic = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'III/c');
  $iiicTotal += $iiic;
  $iiid = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'III/d');
  $iiidTotal += $iiid;
  
  $iia = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'II/a');
  $iiaTotal += $iia; 
  $iib = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'II/b');
  $iibTotal += $iib;
  $iic = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'II/c');
  $iicTotal += $iic;
  $iid = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'II/d');
  $iidTotal += $iid;
  
  $ia = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'I/a');
  $iaTotal += $ia;
  $ib = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'I/b');;
  $ibTotal += $ib;
  $ic = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'I/c');;
  $icTotal += $ic;
  $id = countPegawaiBySkpdAndGolongan($rUnitKerja[id_unit_kerja], 'I/d');
  $idTotal += $id;
?>
	<tr>
		<td class="number"><?php echo $i; ?></td>
		<td><?php echo $rUnitKerja['nama_baru']; ?></td>
		
    <td class="number"><?php echo $iva; ?></td>
    <td class="number"><?php echo $ivb; ?></td>
    <td class="number"><?php echo $ivc; ?></td>
    <td class="number"><?php echo $ivd; ?></td>
    <td class="number"><?php echo $ive; ?></td>
    <td class="number"><?php echo $iva + $ivb + $ivc + $ivd + $ive; ?></td>
    
    <td class="number"><?php echo $iiia; ?></td>
    <td class="number"><?php echo $iiib; ?></td>
    <td class="number"><?php echo $iiic; ?></td>
    <td class="number"><?php echo $iiid; ?></td>    
    <td class="number"><?php echo $iiia + $iiib + $iiic + $iiid; ?></td>
    
    <td class="number"><?php echo $iia; ?></td>
    <td class="number"><?php echo $iib; ?></td>
    <td class="number"><?php echo $iic; ?></td>
    <td class="number"><?php echo $iid; ?></td>    
    <td class="number"><?php echo $iia + $iib + $iic + $iid; ?></td>
    
    <td class="number"><?php echo $ia; ?></td>
    <td class="number"><?php echo $ib; ?></td>
    <td class="number"><?php echo $ic; ?></td>
    <td class="number"><?php echo $id; ?></td>    
    <td class="number"><?php echo $ia + $ib + $ic + $id; ?></td>
    
    <td class="number"><?php echo $iva + $ivb + $ivc + $ivd + $ive + $iiia 
                        + $iiib + $iiic + $iiid + $iia + $iib + $iic + 
                        $iid + $ia + $ib + $ic + $id; ?></td>
	</tr>
<?php $i++; ?>
<?php endwhile; ?>
<tr>
	<th colspan="2" >
		<strong>JUMLAH</strong>
	</th>
	<th class="number"><?php echo $ivaTotal; ?></th>
  <th class="number"><?php echo $ivbTotal; ?></th>
  <th class="number"><?php echo $ivcTotal; ?></th>
  <th class="number"><?php echo $ivdTotal; ?></th>
  <th class="number"><?php echo $iveTotal; ?></th>
  <th class="number"><?php echo $ivaTotal + $ivbTotal + $ivcTotal + $ivdTotal + $iveTotal; ?></th>
  
  <th class="number"><?php echo $iiiaTotal; ?></th>
  <th class="number"><?php echo $iiibTotal; ?></th>
  <th class="number"><?php echo $iiicTotal; ?></th>
  <th class="number"><?php echo $iiidTotal; ?></th>  
  <th class="number"><?php echo $iiiaTotal + $iiibTotal + $iiicTotal + $iiidTotal; ?></th>
  
  <th class="number"><?php echo $iiaTotal; ?></th>
  <th class="number"><?php echo $iibTotal; ?></th>
  <th class="number"><?php echo $iicTotal; ?></th>
  <th class="number"><?php echo $iidTotal; ?></th>  
  <th class="number"><?php echo $iiaTotal + $iibTotal + $iicTotal + $iidTotal; ?></th>
  
  <th class="number"><?php echo $iaTotal; ?></th>
  <th class="number"><?php echo $ibTotal; ?></th>
  <th class="number"><?php echo $icTotal; ?></th>
  <th class="number"><?php echo $idTotal; ?></th>  
  <th class="number"><?php echo $iaTotal + $ibTotal + $icTotal + $idTotal; ?></th>
  
  <th class="number"><?php echo $ivaTotal + $ivbTotal + $ivcTotal + $ivdTotal + $iveTotal + 
                                $iiiaTotal + $iiibTotal + $iiicTotal + $iiidTotal +
                                $iiaTotal + $iibTotal + $iicTotal + $iidTotal + 
                                $iaTotal + $ibTotal + $icTotal + $idTotal; ?></th>
</tr>
</table>