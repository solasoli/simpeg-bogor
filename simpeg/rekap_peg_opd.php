<!--a href="eksporrekap.php" target="_blank"><div>Export Rekap ke excel  <span class="label label-important">Export</span></div></a-->



<h2> REKAPITULASI PEGAWAI <?php echo strtoupper($unit['nama_baru']) ?> Per <?php echo date('F Y');?> </h2>
</br>

<?php

$result = mysqli_query($mysqli,"SELECT LEFT(NOW(),10) AS tanggal, id_pegawai,COUNT(id_pegawai) AS jumlah FROM pegawai
where flag_pensiun =0");

$qskpd=mysqli_query($mysqli,"select id_skpd from unit_kerja where id_unit_kerja=$unit[0]");
$skpd=mysqli_fetch_array($qskpd);

?>

<h4>Berdasarkan Golongan dan Eselon </h4>
<?php
$result = mysqli_query($mysqli,"select pangkat_gol,
sum(if(eselon like 'Ia', jumlah, 0)) as 'Ia',
sum(if(eselon like 'Ib', jumlah, 0)) as 'Ib',
sum(if(eselon like 'IIa', jumlah, 0)) as 'IIa',
sum(if(eselon like 'IIb', jumlah, 0)) as 'IIb',
sum(if(eselon like 'IIIa', jumlah, 0)) as 'IIIa',
sum(if(eselon like 'IIIb', jumlah, 0)) as 'IIIb',
sum(if(eselon like 'IVa', jumlah, 0)) as 'IVa',
sum(if(eselon like 'IVb', jumlah, 0)) as 'IVb',
sum(if(eselon like 'V', jumlah, 0)) as 'Va',
sum(if(jenjab not like 'struktural', jumlah, 0)) as 'Fungsional',
sum(if(eselon is NULL and jenjab like 'struktural', jumlah, 0)) as 'Staf',
sum(jumlah) as Total
from
(
select jenjab, eselon, pangkat_gol, count(*) as jumlah from pegawai p 
left join jabatan j on j.id_j = p.id_j
left join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
left join unit_kerja on clk.id_unit_kerja = unit_kerja.id_unit_kerja
where flag_pensiun = 0
and id_skpd = $skpd[0]
group by jenjab, pangkat_gol, eselon
) as t 
group by pangkat_gol with rollup");

//var_dump($result);
//echo "</br>";
//var_dump($_SESSION);
?>
<table class="table table-bordered table-responsive">
<thead>
<tr>
	<th rowspan="2" style="background-color:orange">
		GOLONGAN
	</th>
	<th colspan="9" align="center" style="background-color:orange">
		ESELON
	</th>
	<th rowspan="2" style="background-color:orange">Fungsional</th>
	<th rowspan="2" style="background-color:orange">Fungsional Umum</th>
	<th rowspan="2" style="background-color:orange">Total</th>
</tr>
<tr>
	<th style="background-color:orange">Ia</th>
	<th style="background-color:orange">Ib</th>
	<th style="background-color:orange">IIa</th>
	<th style="background-color:orange">IIb</th>
	<th style="background-color:orange">IIIa</th>
	<th style="background-color:orange">IIIb</th>
	<th style="background-color:orange">IVa</th>
	<th style="background-color:orange">IVb</th>
	<th style="background-color:orange">Va</th>	
</tr>
</thead>
<tbody>
<?php while($r = mysqli_fetch_array($result)): ?>
	<tr>
		<td><?php echo $r['pangkat_gol']; ?></td>		
		<td><?php echo $r['Ia']; ?></td>		
		<td><?php echo $r['Ib']; ?></td>		
		<td><?php echo $r['IIa']; ?></td>		
		<td><?php echo $r['IIb']; ?></td>		
		<td><?php echo $r['IIIa']; ?></td>		
		<td><?php echo $r['IIIb']; ?></td>	
		<td><?php echo $r['IVa']; ?></td>				
		<td><?php echo $r['IVb']; ?></td>		
		<td><?php echo $r['Va']; ?></td>		
		<td><?php echo $r['Fungsional']; ?></td>		
		<td><?php echo $r['Staf']; ?></td>		
		<td><?php echo $r['Total']; ?></td>		
	</tr>
<?php endwhile ?>
</tbody>
</table>
</br>

<div class="row">
	<div class="col-md-4">
	
		<h4>Berdasarkan Usia</h4>
		<?php
		$result = mysqli_query($mysqli,"SELECT CASE 
		WHEN ( FLOOR(datediff(CURRENT_DATE,tgl_lahir)/365) BETWEEN 0 AND  24) THEN '<25' 
		WHEN ( FLOOR(datediff(CURRENT_DATE,tgl_lahir)/365) BETWEEN 25 AND 30) THEN '25-30' 
		WHEN ( FLOOR(datediff(CURRENT_DATE,tgl_lahir)/365) BETWEEN 31 AND 35) THEN '31-35'
		WHEN ( FLOOR(datediff(CURRENT_DATE,tgl_lahir)/365) BETWEEN 36 AND 40) THEN '36-40'
		WHEN ( FLOOR(datediff(CURRENT_DATE,tgl_lahir)/365) BETWEEN 41 AND 45) THEN '41-45'
		WHEN ( FLOOR(datediff(CURRENT_DATE,tgl_lahir)/365) BETWEEN 46 AND 50) THEN '46-50'
		WHEN ( FLOOR(datediff(CURRENT_DATE,tgl_lahir)/365) BETWEEN 51 AND 55) THEN '51-55'
		WHEN ( FLOOR(datediff(CURRENT_DATE,tgl_lahir)/365) BETWEEN 56 AND 60) THEN '56-60'
		WHEN ( FLOOR(datediff(CURRENT_DATE,tgl_lahir)/365) BETWEEN 61 AND 65) THEN '>61'
		END as 'USIA',
		COUNT(*) as 'JUMLAH'
		FROM
		pegawai 
		left join current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai
		left join unit_kerja on clk.id_unit_kerja = unit_kerja.id_unit_kerja
		where flag_pensiun = 0
		and id_skpd = $skpd[0]
		GROUP BY USIA");
		?>
		<table class="table table-bordered">
		<thead>
		<tr>
			<th style="background-color:orange">
				USIA
			</th>
			<th style="background-color:orange">
				Jumlah
			</th>
		</tr>
		</thead>
		<tbody>
		<?php 
			$jumlah_usia = 0;
			while($r = mysqli_fetch_array($result)): ?>
			<tr>
				<td><center>
					<?php echo $r['USIA']; ?>&nbsp;
				</center></td>
				<td align="right"><center>
					<?php echo $r['JUMLAH']; $jumlah_usia = $jumlah_usia + $r['JUMLAH'];?>
				</center></td>
			</tr>	
		<?php endwhile ?>
			<tr>
				<td>Jumlah</td>
				<td><center><?php echo $jumlah_usia ?></center> </td>
			</tr>
		</tbody>
		</table>
		</br>
	</div>
	<div class="col-md-4">

		<h4>Berdasarkan Pendidikan</h4>
		<?php
		/*$result = mysqli_query($mysqli,"SELECT nama_pendidikan, COUNT( * ) AS Jumlah
		FROM pendidikan_terakhir
		INNER JOIN pegawai ON pegawai.id_pegawai = pendidikan_terakhir.id_pegawai
		INNER JOIN kategori_pendidikan ON pendidikan_terakhir.level_p = kategori_pendidikan.min_level_p
		INNER JOIN current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai 
		AND flag_pensiun =0
		AND clk.id_unit_kerja = $unit[0]
		GROUP BY nama_pendidikan");
		*/
		$result = mysqli_query($mysqli,"SELECT tingkat_pendidikan as nama_pendidikan, COUNT( * ) AS Jumlah
		FROM pegawai p
		INNER JOIN current_lokasi_kerja c ON p.id_pegawai = c.id_pegawai
		INNER JOIN unit_kerja u ON c.id_unit_kerja = u.id_unit_kerja
		INNER JOIN pendidikan_terakhir t ON p.id_pegawai = t.id_pegawai
		WHERE u.id_unit_kerja = $unit[0]
		GROUP BY nama_pendidikan
		");

		?>
		<table class="table table-bordered">
		<tr>
			<td style="background-color:orange"><font color="white">
				Tingkat Pendidikan <?php echo $unit[0] ?>
			</td>
			<td style="background-color:orange"><font color="white">
				Jumlah
			</td>
		</tr>

		<?php 
		$jumlah_pendidikan = 0;
		while($r = mysqli_fetch_array($result)): ?>
			<tr>
				<td>
					<?php echo $r['nama_pendidikan']; ?>&nbsp;
				</td>
				<td align="right">
					<?php echo $r['Jumlah']; $jumlah_pendidikan = $jumlah_pendidikan + $r['Jumlah'];?>
				</td>
			</tr>
		<?php endwhile ?>
		<tr>
				<td>Jumlah</td>
				<td><center><?php echo $jumlah_pendidikan ?></center> </td>
			</tr>
		</table>
		<br/>
	</div>
	<div class="col-md-4">
		<h4>Berdasarkan Jenis Kelamin</h4>
		<?php
		$result = mysqli_query($mysqli,"SELECT LEFT(NOW(), 10) AS tanggal, jenis_kelamin, COUNT(jenis_kelamin) AS jumlah 
		FROM pegawai 
		inner join current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai
		where flag_pensiun = 0
		and clk.id_unit_kerja = $unit[0]
		GROUP BY jenis_kelamin");
		?>
		<table class="table table-bordered">
		<thead>
		<tr>
			<th style="background-color:orange"><font color="white">
				Jenis Kelamin
			</th>
			<th style="background-color:orange"><font color="white">
				Jumlah
			</th>
		</tr>
		</thead>
		<?php while($r = mysqli_fetch_array($result)): ?>
			<tr>
				<td>
					<?php echo $r['jenis_kelamin']; ?>&nbsp;
				</td>
				<td align="right">
					<?php echo $r['jumlah']; ?>&nbsp;
				</td>
			</tr>
		<?php endwhile ?>
		</table>
	</div>
</div>
<div class="row>">
	<div class="col-md-6">
<h4>Berdasarkan Golongan</h4>
<?php
$result = mysqli_query($mysqli,"SELECT LEFT(NOW(), 10) AS tanggal, pangkat_gol, COUNT(pangkat_gol) AS jumlah 
FROM pegawai 
Left join current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai
where flag_pensiun = 0
and clk.id_unit_kerja = $unit[0]
GROUP BY pangkat_gol");
?>
<table class="table table-bordered">
<thead>
<tr>
	<th style="background-color:orange"><font color="white">
		Golongan
	</th>
	<th style="background-color:orange"><font color="white">
		Jumlah
	</th>
</tr>
</thead>
<tbody>
<?php 
$jumlah_golongan = 0;
while($r = mysqli_fetch_array($result)): ?>
	<tr>
		<td>
			<?php echo $r['pangkat_gol']; ?>&nbsp;
		</td>
		<td align="right">
			<?php echo $r['jumlah']; $jumlah_golongan = $jumlah_golongan + $r['jumlah']; ?>
		</td>
	</tr>
<?php endwhile ?>
<tr>
		<td>Jumlah</td>
		<td><center><?php echo $jumlah_golongan ?></center> </td>
	</tr>
</tbody>
</table>
<br/>
	</div>
	<div class="col-md-6">
<h4>Berdasarkan Eselon</h4>
<?php
$jumlah_eselon = 0;
$result = mysqli_query($mysqli,"SELECT LEFT(NOW(),10) AS tanggal, eselon,COUNT(eselon) AS jumlah 
FROM pegawai
INNER JOIN jabatan ON jabatan.id_j = pegawai.id_j and flag_pensiun = 0 
left join current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai
where clk.id_unit_kerja = $unit[0]
GROUP BY eselon");
?>
<table class="table table-bordered">
<thead>
<tr>
	<td style="background-color:orange"><font color="white">
		Eselon
	</td>
	<td style="background-color:orange"><font color="white">
		Jumlah
	</td>
</tr>
</thead>
<?php while($r = mysqli_fetch_array($result)): ?>
	<tr>
		<td>
			<?php echo $r['eselon']; ?>&nbsp;
		</td>
		<td align="right">
			<?php echo $r['jumlah']; $jumlah_eselon = $jumlah_eselon + $r['jumlah'];  ?>
		</td>
	</tr>
<?php endwhile ?>
<tr>
		<td>Jumlah</td>
		<td><center><?php echo $jumlah_eselon?></center> </td>
	</tr>
</table>
</br>
	</div>
</div>
