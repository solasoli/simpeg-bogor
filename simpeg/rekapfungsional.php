<a href="eksporrekapfungsional.php" target="_blank"><div>Export Rekap ke excel</div></a>
</br>
</br>
<?php require_once("konek.php"); ?>
<script type="text/javascript" src="lib/js/jquery-ui-1.8.2.custom.min"></script>
<b><font color="black" size="3px"> Rekapitulasi Data Pejabat Fungsional Kota Bogor Per <?php echo date('F Y');?> </font></b>
</br>
</br>
<?php
$result = mysqli_query($mysqli,"SELECT LEFT(NOW(),10) AS tanggal, id_pegawai,COUNT(id_pegawai) AS jumlah FROM pegawai
where flag_pensiun =0 and jenjab like'%fungsional%'");
?>
<table border="1">
<tr>

	<td style="background-color:blue"><font color="white">
		Jumlah Pejabat Fungsional
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
<br>
<br>
<?php
$result = mysqli_query($mysqli,"select jabatan,
sum(if(pangkat_gol like 'II/a', jumlah, 0)) as 'II/a',
sum(if(pangkat_gol like 'II/b', jumlah, 0)) as 'II/b',
sum(if(pangkat_gol like 'II/c', jumlah, 0)) as 'II/c',
sum(if(pangkat_gol like 'II/d', jumlah, 0)) as 'II/d',
sum(if(pangkat_gol like 'III/a', jumlah, 0)) as 'III/a',
sum(if(pangkat_gol like 'III/b', jumlah, 0)) as 'III/b',
sum(if(pangkat_gol like 'III/c', jumlah, 0)) as 'III/c',
sum(if(pangkat_gol like 'III/d', jumlah, 0)) as 'III/d',
sum(if(pangkat_gol like 'IV/a', jumlah, 0)) as 'IV/a',
sum(if(pangkat_gol like 'IV/b', jumlah, 0)) as 'IV/b',
sum(if(pangkat_gol like 'IV/c', jumlah, 0)) as 'IV/c',
sum(if(pangkat_gol like 'IV/d', jumlah, 0)) as 'IV/d',
sum(if(pangkat_gol like 'IV/e', jumlah, 0)) as 'IV/e',
sum(jumlah) as Total
from
(
    select jabatan, pangkat_gol, count(*) as jumlah
    from pegawai p 
    where p.flag_pensiun = 0
    and jenjab like 'fungsional'
    group by jabatan, pangkat_gol
    order by jabatan, pangkat_gol desc
) as t 
group by jabatan with rollup");
?>
<table border="1" >
<tr>
	<td align="center" style="background-color:blue"><font color="white"> No</td>
	<td align="center" style="background-color:blue"><font color="white">
		Jabatan
	</td>
	<td align="center" style="background-color:blue"><font color="white">II/a</td>
	<td align="center" style="background-color:blue"><font color="white">II/b</td>
	<td align="center" style="background-color:blue"><font color="white">II/c</td>
	<td align="center" style="background-color:blue"><font color="white">II/d</td>
	<td align="center" style="background-color:blue"><font color="white">III/a</td>
	<td align="center" style="background-color:blue"><font color="white">III/b</td>
	<td align="center" style="background-color:blue"><font color="white">III/c</td>
	<td align="center" style="background-color:blue"><font color="white">III/d</td>
	<td align="center" style="background-color:blue"><font color="white">IV/a</td>
	<td align="center" style="background-color:blue"><font color="white">IV/b</td>
	<td align="center" style="background-color:blue"><font color="white">IV/c</td>
	<td align="center" style="background-color:blue"><font color="white">IV/d</td>
	<td align="center" style="background-color:blue"><font color="white">IV/e</td>
	
	<td align="center" style="background-color:blue"><font color="white">
		Jumlah
	</td>
</tr>
<? $numrow = mysqli_num_rows($result); ?>
<?php $x=1; $y=0; while($r = mysqli_fetch_array($result)): ?>
	<?php if($x==$numrow): ?>
		<tr>
			<td>&nbsp;</td>
			<td><strong>JUMLAH</strong></td>
			<td style="padding:5px" align="right"><strong><?php echo $r['II/a']; ?></strong></td>
			<td style="padding:5px" align="right"><strong><?php echo $r['II/b']; ?></strong></td>
			<td style="padding:5px" align="right"><strong><?php echo $r['II/c']; ?></strong></td>
			<td style="padding:5px" align="right"><strong><?php echo $r['II/d']; ?></strong></td>
			<td style="padding:5px" align="right"><strong><?php echo $r['III/a']; ?></strong></td>
			<td style="padding:5px" align="right"><strong><?php echo $r['III/b']; ?></strong></td>
			<td style="padding:5px" align="right"><strong><?php echo $r['III/c']; ?></strong></td>
			<td style="padding:5px" align="right"><strong><?php echo $r['III/d']; ?></strong></td>
			<td style="padding:5px" align="right"><strong><?php echo $r['IV/a']; ?></strong></td>
			<td style="padding:5px" align="right"><strong><?php echo $r['IV/b']; ?></strong></td>
			<td style="padding:5px" align="right"><strong><?php echo $r['IV/c']; ?></strong></td>
			<td style="padding:5px" align="right"><strong><?php echo $r['IV/d']; ?></strong></td>
			<td style="padding:5px" align="right"><strong><?php echo $r['IV/e']; ?></strong></td>
			<td style="padding:5px" align="right"><strong><?php echo $r['Total']; $y = $y + $r['jumlah']  ?></strong></td>
		</tr>
	<?php else: ?>
		<tr>
			<td style="padding:5px" align="center"><?php echo $x++;?></td>
			<td style="padding:5px" ><?php echo $r['jabatan']; ?></td>
			<td style="padding:5px" align="right"><?php echo $r['II/a']; ?></td>
			<td style="padding:5px" align="right"><?php echo $r['II/b']; ?></td>
			<td style="padding:5px" align="right"><?php echo $r['II/c']; ?></td>
			<td style="padding:5px" align="right"><?php echo $r['II/d']; ?></td>
			<td style="padding:5px" align="right"><?php echo $r['III/a']; ?></td>
			<td style="padding:5px" align="right"><?php echo $r['III/b']; ?></td>
			<td style="padding:5px" align="right"><?php echo $r['III/c']; ?></td>
			<td style="padding:5px" align="right"><?php echo $r['III/d']; ?></td>
			<td style="padding:5px" align="right"><?php echo $r['IV/a']; ?></td>
			<td style="padding:5px" align="right"><?php echo $r['IV/b']; ?></td>
			<td style="padding:5px" align="right"><?php echo $r['IV/c']; ?></td>
			<td style="padding:5px" align="right"><?php echo $r['IV/d']; ?></td>
			<td style="padding:5px" align="right"><?php echo $r['IV/e']; ?></td>
			<td style="padding:5px" align="right"><strong><?php echo $r['Total']; $y = $y + $r['jumlah']  ?></strong></td>
		</tr>
	<?php endif; ?>
	
<?php endwhile ?>	
</table>
<br>
<a href="index3.php?x=daftar_pejabat_fungsional.php">Daftar Pejabat Fungsional</a>
<br/>
