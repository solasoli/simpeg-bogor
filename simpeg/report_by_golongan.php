<center><h1>REKAPITULASI JUMLAH PEGAWAI BERDASARKAN GOLONGAN RUANG</h1></center>
<br/>
<?php
include 'konek.php';

$res = mysqli_query($mysqli,'call PRC_REPORT_BY_GOLONGAN()');

if(mysqli_num_rows($res)>0)
{
	?>
<div class="table-responsive">
	<table class="table table-striped">	
	<thead>
	<tr>
		<th>
			Unit Kerja
		</th>
		<th>
			IV/a
		</th>
		<th>
			IV/b
		</th>
		<th>
			IV/c
		</th>
		<th>
			IV/d
		</th>
		<th>
			IV/e
		</th>
		<th>
			IV
		</th>
		<th>
			III/a
		</th>
		<th>
			III/b
		</th>
		<th>
			III/c
		</th>
		<th>
			III/d
		</th>
		<th>
			III
		</th>
		<th>
			II/a
		</th>
		<th>
			II/b
		</th>
		<th>
			II/c
		</th>
		<th>
			II/d
		</th>
		<th>
			II
		</th>
		<th>
			I/a
		</th>
		<th>
			I/b
		</th>
		<th>
			I/c
		</th>
		<th>
			I/d
		</th>
		<th>
			I
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
			<?php echo $row['IV/a']; ?>
		</td>
		<td>
			<?php echo $row['IV/b']; ?>
		</td>
		<td>
			<?php echo $row['IV/c']; ?>
		</td>
		<td>
			<?php echo $row['IV/d']; ?>
		</td>
		<td>
			<?php echo $row['IV/e']; ?>
		</td>
		<td>
			<?php echo $row['IV']; ?>
		</td>
		<td>
			<?php echo $row['III/a']; ?>
		</td>
		<td>
			<?php echo $row['III/b']; ?>
		</td>
		<td>
			<?php echo $row['III/c']; ?>
		</td>
		<td>
			<?php echo $row['III/d']; ?>
		</td>
		<td>
			<?php echo $row['III']; ?>
		</td>
		<td>
			<?php echo $row['II/a']; ?>
		</td>
		<td>
			<?php echo $row['II/b']; ?>
		</td>
		<td>
			<?php echo $row['II/c']; ?>
		</td>
		<td>
			<?php echo $row['II/d']; ?>
		</td>
		<td>
			<?php echo $row['II']; ?>
		</td>
		<td>
			<?php echo $row['I/a']; ?>
		</td>
		<td>
			<?php echo $row['I/b']; ?>
		</td>
		<td>
			<?php echo $row['I/c']; ?>
		</td>
		<td>
			<?php echo $row['I/d']; ?>
		</td>
		<td>
			<?php echo $row['I']; ?>
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
</div>
	<?php
}
else
{
	echo "Query doesn't have result.";
}

?>