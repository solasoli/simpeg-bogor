<?php
include_once "../konek.php";
include_once "../lib/PegawaiRepository.php";
include_once "../lib/JabatanRepository.php";
?>
<table border="1" style="border-collapse: collapse" width="100%">
<tr>
	<th rowspan="3">No</th>
	<th rowspan="3">Unit Kerja</th>
	<th colspan="5" rowspan="2">Jumlah Eselon Seluruhnya</th>
	<th colspan="15">Eselon</th>	
  <th rowspan="3">Jumlah Eselon yg terisi</th>
  <th rowspan="3">Jumlah Eselon blm terisi</th>
</tr>
<tr>
	<th colspan="3">I</th>
	<th colspan="3">II</th>
  <th colspan="3">III</th>
  <th colspan="3">IV</th>
  <th colspan="3">V</th>
</tr>
<tr>
	<th>I</th>
  <th>II</th>
  <th>III</th>
  <th>IV</th>
  <th>V</th>
  
  <th>A</th>  
  <th>B</th>
  <th>JML</th>
  
  <th>A</th>
  <th>B</th>
  <th>JML</th>
  
  <th>A</th>
  <th>B</th>
  <th>JML</th>
  
  <th>A</th>
  <th>B</th>
  <th>JML</th>
  
  <th>A</th>
  <th>B</th>
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

$ITotal = 0;
$IITotal = 0;
$IIITotal = 0;
$IVTotal = 0;
$VTotal = 0;

?>
<?php while($rUnitKerja = mysql_fetch_array($rsUnitKerja)): ?>
<?php
	$I = countJabatanBySkpdAndEselon($rUnitKerja['id_unit_kerja'], 'I');
  $ITotal += 
  $II = countJabatanBySkpdAndEselon($rUnitKerja['id_unit_kerja'], 'II');
?>
	<tr>
		<td class="number"><?php echo $i; ?></td>
		<td><?php echo $rUnitKerja[nama_baru]; ?></td>
		
    <td class="number"><?php echo $I; ?></td>
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