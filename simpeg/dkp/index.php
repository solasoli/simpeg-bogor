<?php include_once "lib/main_page.php" ?>
<html>
<head>
	<title>Aplikasi Manajemen Kepegawaian - Dinas Kebersihan dan Pertamanan Kota Bogor</title>
</head>
<body>
<h1>DINAS KEBERSIHAN dan PERTAMANAN KOTA BOGOR<h1>
<h2>Aplikasi Manajemen Pegawai 2011</h2>
<hr/>
| DUK | DUN 
| <a href="kgb.php" target="_BLANK">KGB</a> 
| <a href="kp.php" target="_BLANK">KP</a> 
| <a href="pensiun.php" target="_BLANK">Pensiun</a> |
<br/><br/>
<div>
<table border="1" width="100%">
	<thead>
	<tr>
		<td>No</td>	
		<td>Nama</td>
		<td>NIP</td>
		<td>TTL</td>
		<td>Golongan</td>
	</tr>
	</thead>
	<tbody>
	<?php foreach($result as $r): ?>
	<tr>
		<td><?php echo $r["no"] ?></td>	
		<td>
			<a href="data_pegawai.php?id=<?php echo $r['id_pegawai']?>"target="_BLANK">
			<?php echo $r["nama"] ?>
		</td>
		<td><?php echo $r["nip"] ?></td>
		<td><?php echo $r["tempat_lahir"].", ".$r["tgl_lahir"] ?></td>
		<td><?php echo $r["gol"] ?></td>
	</tr>	
	<?php endforeach; ?>
	</tbody>
</table>
</div>
</body>
</html>