<?php 
	include_once "lib/pensiun.php";
?>
<html>
<head>
	<title>Daftar Pensiun</title>
</head>
<body>
<h1>DAFTAR PEGAWAI DINAS KEBERSIHAN dan PERTAMANAN YANG PENSIUN</h1>
<table border="1" width="100%">
<thead>
<tr>
	<td>No</td>
	<td>Nama</td>
	<td>NIP</td>
	<td>TTL</td>
	<td>TMT Pensiun</td>
	<td>Pangkat</td>
	<td>Jabatan</td>
</tr>
</thead>
<tbody>
<?php foreach($result as $r): ?>
<tr>
	<td><?php echo $r["no"] ?></td>
	<td><?php echo $r["nama"] ?></td>
	<td><?php echo $r["nip"] ?></td>
	<td><?php echo $r["ttl"] ?></td>
	<td><?php echo $r["tmt_pensiun"] ?></td>
	<td><?php echo $r["pangkat"] ?></td>
	<td><?php echo $r["jabatan"] ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</body>
</html>