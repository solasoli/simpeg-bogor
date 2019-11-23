<center><h1>REKAPITULASI JUMLAH PEGAWAI BERDASARKAN JENIS KELAMIN</h1></center>
<br/>
<?php
include 'konek.php';

$res = $mysqli->query('call PRC_REPORT_BY_GENDER()');

if(mysqli_num_rows($res)>0)
{
	?>
	<table class="table table-striped">	
	<thead>
	<tr>
		<th>
			Unit Kerja
		</th>
		<th>
			L
		</th>
		<th>
			P
		</th>
		<th>
			Total
		</th>		
	</tr>	
	</thead>
	<tbody>
	<?php
	while($row = mysqli_fetch_array($res))
	{		
		?>
	<tr>
		<td>
			<?php echo $row['Unit Kerja']; ?>
		</td>
		<td>
			<?php echo $row['L']; ?>
		</td>
		<td>
			<?php echo $row['P']; ?>
		</td>
		<td>
			<?php echo $row['Total']; ?>
		</td>		
	</tr>
		<?php
	}
	?>
	</tbody>
	</table>
	<?php
}
else
{
	echo "Query doesn't have result.";
}

?>