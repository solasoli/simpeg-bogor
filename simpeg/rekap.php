<a href="eksporrekap.php" target="_blank"><div>Export Rekap ke excel  <span class="label label-important">Export</span></div></a>
</br>
<?php require_once("konek.php"); ?>
<script type="text/javascript" src="lib/js/jquery-ui-1.8.2.custom.min"></script>
<b><font color="black" size="3px"> Rekapitulasi Data Pegawai PNS Kota Bogor Per <?php echo date('F Y');?> </font></b>
</br>
</br>
JUMLAH PEGAWAI
<?php
$result = mysql_query("SELECT LEFT(NOW(),10) AS tanggal, id_pegawai,COUNT(id_pegawai) AS jumlah FROM pegawai
where flag_pensiun =0");
?>
<table border="1">
<tr>
	<td style="background-color:blue"><font color="white">
		Jumlah Pegawai
	</td>
</tr>

<?php while($r = mysql_fetch_array($result)): ?>
	<tr>
		<td align="right">
			<?php echo $r['jumlah']; ?>
		</td>
	</tr>
<?php endwhile ?>
</table>
</br>
JENIS KELAMIN
<?php
$result = mysql_query("SELECT LEFT(NOW(), 10) AS tanggal, jenis_kelamin, COUNT(jenis_kelamin) AS jumlah FROM pegawai where flag_pensiun = 0
GROUP BY jenis_kelamin");
?>
<table border="1">
<tr>
	<td style="background-color:blue"><font color="white">
		Jenis Kelamin
	</td>
	<td style="background-color:blue"><font color="white">
		Jumlah
	</td>
</tr>

<?php while($r = mysql_fetch_array($result)): ?>
	<tr>
		<td>
			<?php echo $r['jenis_kelamin'] == '1' ? "Laki-laki" : "Perempuan"; ?>&nbsp;
		</td>
		<td align="right">
			<?php echo $r['jumlah']; ?>&nbsp;
		</td>
	</tr>
<?php endwhile ?>
</table>
<br>

JUMLAH PEGAWAI PER GOLONGAN DAN PER JABATAN TAHUN <?php echo date('Y'); ?>
<?php
$result = mysql_query("select nama, pangkat_gol,
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
select nama, jenjab, eselon, pangkat_gol, count(*) as jumlah from pegawai p 
left join jabatan j on j.id_j = p.id_j
where flag_pensiun = 0
group by jenjab, pangkat_gol, eselon
) as t 
group by pangkat_gol with rollup");
?>
<table border="1">
<thead>
<tr>	
	<th rowspan="2" style="background-color:blue"><font color="white">
		GOLONGAN
	</th>
	<th colspan="9" style="background-color:blue"><font color="white">
		ESELON
	</th>
	<th rowspan="2" style="background-color:blue"><font color="white">Fungsional</th>
	<th rowspan="2" style="background-color:blue"><font color="white">Fungsional Umum</th>
	<th rowspan="2" style="background-color:blue"><font color="white">Total</th>
</tr>
<tr>
	<th style="background-color:blue"><font color="white">Ia</th>
	<th style="background-color:blue"><font color="white">Ib</th>
	<th style="background-color:blue"><font color="white">IIa</th>
	<th style="background-color:blue"><font color="white">IIb</th>
	<th style="background-color:blue"><font color="white">IIIa</th>
	<th style="background-color:blue"><font color="white">IIIb</th>
	<th style="background-color:blue"><font color="white">IVa</th>
	<th style="background-color:blue"><font color="white">IVb</th>
	<th style="background-color:blue"><font color="white">Va</th>	
</tr>
</thead>
<tbody>
<?php while($r = mysql_fetch_array($result)): ?>
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

USIA
<?php
$result = mysql_query("SELECT CASE 
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
pegawai where flag_pensiun = 0
GROUP BY USIA");
?>
<table border="1">
<tr>
	<td style="background-color:blue"><font color="white">
		USIA
	</td>
	<td style="background-color:blue"><font color="white">
		Jumlah
	</td>
</tr>

<?php 
	$jumlah_usia = 0;
	while($r = mysql_fetch_array($result)): ?>
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
</table>
</br>

PENDIDIKAN
<?php
$result = mysql_query("SELECT tingkat_pendidikan, COUNT( * ) AS Jumlah
FROM pendidikan_terakhir
INNER JOIN pegawai ON pegawai.id_pegawai = pendidikan_terakhir.id_pegawai
AND flag_pensiun =0
GROUP BY tingkat_pendidikan order by level_p DESC");
?>
<table border="1">
<tr>
	<td style="background-color:blue"><font color="white">
		Tingkat Pendidikan
	</td>
	<td style="background-color:blue"><font color="white">
		Jumlah
	</td>
</tr>

<?php 
$jumlah_pendidikan = 0;
while($r = mysql_fetch_array($result)): ?>
	<tr>
		<td>
			<?php echo $r['tingkat_pendidikan']; ?>&nbsp;
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

GOLONGAN
<?php
$result = mysql_query("SELECT LEFT(NOW(), 10) AS tanggal, pangkat_gol, COUNT(pangkat_gol) AS jumlah FROM pegawai where flag_pensiun =0
GROUP BY pangkat_gol");
?>
<table border="1">
<tr>
	<td style="background-color:blue"><font color="white">
		Golongan
	</td>
	<td style="background-color:blue"><font color="white">
		Jumlah
	</td>
</tr>

<?php 
$jumlah_golongan = 0;
while($r = mysql_fetch_array($result)): ?>
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
</table>
<br/>

ESELON
<?php
$jumlah_eselon = 0;
$result = mysql_query("SELECT LEFT(NOW(),10) AS tanggal, eselon,COUNT(eselon) AS jumlah FROM pegawai
INNER JOIN jabatan
ON jabatan.id_j = pegawai.id_j and flag_pensiun = 0
GROUP BY eselon");
?>
<table border="1">
<tr>
	<td style="background-color:blue"><font color="white">
		Eselon
	</td>
	<td style="background-color:blue"><font color="white">
		Jumlah
	</td>
</tr>

<?php while($r = mysql_fetch_array($result)): ?>
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

DIKLAT PIM II
<?php
$jumlah_eselon = 0;
$result = mysql_query("SELECT LEFT(NOW(),10) AS tanggal, eselon,COUNT(eselon) AS jumlah from pegawai p
inner join jabatan j on p.id_j=j.id_j 
inner join diklat d on p.id_pegawai=d.id_pegawai
where jenis_diklat like '%Kepemimpinan%' and nama_diklat like '%TK.II'  and eselon like 'II%'
GROUP BY eselon");
?>
<table border="1">
<tr>
	<td style="background-color:blue"><font color="white">
		Eselon
	</td>
	<td style="background-color:blue"><font color="white">
		Jumlah
	</td>
</tr>

<?php while($r = mysql_fetch_array($result)): ?>
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
DIKLAT PIM III
<?php
$jumlah_eselon = 0;
$result = mysql_query("SELECT LEFT(NOW(),10) AS tanggal, eselon,COUNT(eselon) AS jumlah from pegawai p
inner join jabatan j on p.id_j=j.id_j 
inner join diklat d on p.id_pegawai=d.id_pegawai
where jenis_diklat like '%Kepemimpinan%' and nama_diklat like '%TK.III'  and eselon like 'III%'
GROUP BY eselon");
?>
<table border="1">
<tr>
	<td style="background-color:blue"><font color="white">
		Eselon
	</td>
	<td style="background-color:blue"><font color="white">
		Jumlah
	</td>
</tr>

<?php while($r = mysql_fetch_array($result)): ?>
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
DIKLAT PIM IV
<?php
$jumlah_eselon = 0;
$result = mysql_query("SELECT LEFT(NOW(),10) AS tanggal, eselon,COUNT(eselon) AS jumlah from pegawai p
inner join jabatan j on p.id_j=j.id_j 
inner join diklat d on p.id_pegawai=d.id_pegawai
where jenis_diklat like '%Kepemimpinan%' and (nama_diklat like '%TK.IV' or nama_diklat like '%ADUM%') and eselon like 'IV%'
GROUP BY eselon");
?>
<table border="1">
<tr>
	<td style="background-color:blue"><font color="white">
		Eselon
	</td>
	<td style="background-color:blue"><font color="white">
		Jumlah
	</td>
</tr>
<?php while($r = mysql_fetch_array($result)): ?>
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
		<td><center><?php echo $jumlah_eselon ?></center> </td>
	</tr>
</table>
<br/>
<a href="eksporrekap.php" target="_blank"><div>Export Rekap ke excel <span class="label label-important">Export</span></div></a>


