<?php
mysql_connect("localhost", "root", "51mp36") or die;
mysql_select_db("simpeg");

$rsUser = mysql_query("SELECT DISTINCT created_by 
					   FROM berkas 
					   WHERE LEFT(created_date, 10)  = CURDATE()
					   ORDER BY created_by ASC");
					   
while ($r = mysql_fetch_array($rsUser)) {
	echo "<a href='?u=$r[0]' >| $r[0] </a>";
}

$q = "SELECT  created_by, created_date, nm_berkas, count(*) as jumlah from berkas
	  where created_by IS NOT NULL and created_by <> 'undang'
	  and LEFT(created_date, 10)  = CURDATE() ";

if(isset($_REQUEST[u]))
{
	$q = $q." AND created_by = '$_REQUEST[u]' ";
}

$q = $q." group by created_by, nm_berkas";

$rs = mysql_query($q);

$total = 0;
$totalHarga = 0;
?>

<table border="1">
	<tr>
		<td>User</td>
		<td>Tanggal</td>
		<td>Berkas</td>
		<td>Jumlah</td>
		<td>Harga/data</td>
		<td>Sub Total</td>
	</tr>

<?php

while($r = mysql_fetch_array($rs))
{
	$total += $r[jumlah];
	$qHargaData = "SELECT * FROM  pkl_data_price p WHERE p.kategori = '$r[nm_berkas]'";
	
	$rsHarga = mysql_query($qHargaData);
	$rHarga = mysql_fetch_array($rsHarga);
	
	$subTotal = $rHarga[1] * $r[jumlah];
	$totalHarga += $subTotal;
?>
	<tr>
		<td><?php echo $r[created_by]; ?></td>
		<td><?php echo $r[created_date]; ?></td>
		<td><?php echo $r[nm_berkas]; ?></td>		
		<td><?php echo $r[jumlah]; ?></td>
		<td><?php echo $rHarga[1]; ?></td>
		<td><?php echo $subTotal; ?></td>
	</tr>
<?php
}
?>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>		
		<td><?php echo $total; ?></td>
		<td>&nbsp;</td>	
		<td>
		<?php if(isset($_REQUEST[u])): ?>
			<?php echo $totalHarga + 8000; ?>
		<?php else: ?>
			<?php echo $totalHarga + 24000; ?>
		<?php endif; ?>
		</td>			
	</tr>
</table>