<center><h1>REKAPITULASI JUMLAH PEGAWAI BERDASARKAN RENTANG USIA</h1></center>
<br/>
<?php
include 'konek.php';

$res = $mysqli->query('call PRC_REPORT_BY_AGE()');

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
			<=25
		</th>
		<th>
			26-30
		</th>
		<th>
			31-35
		</th>
		<th>
			36-40
		</th>
		<th>
			41-45
		</th>
		<th>
			46-50
		</th>
		<th>
			51-55
		</th>
		<th>
			56-60
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
			<?php echo $row['<=25']; ?>
		</td>
		<td>
			<?php echo $row['26-30']; ?>
		</td>
		<td>
			<?php echo $row['31-35']; ?>
		</td>
		<td>
			<?php echo $row['36-40']; ?>
		</td>
		<td>
			<?php echo $row['41-45']; ?>
		</td>
		<td>
			<?php echo $row['46-50']; ?>
		</td>
		<td>
			<?php echo $row['51-55']; ?>
		</td>
		<td>
			<?php echo $row['56-60']; ?>
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