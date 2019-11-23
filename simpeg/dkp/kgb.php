<?php include_once "lib/kgb.php"; ?>
<html>
<head>
	<title>Kenaikan Gaji Berkala</title>
</head>
<body>
<h1>PENJAGAAN KENAIKAN GAJI BERKALA<br/>DINAS KEBERSIHAN dan PERTAMANAN KOTA BOGOR</h1>
<table border="1" width="100%">
<thead>
<tr>
	<td>No</td>
	<td>Nama/NIP</td>
	<td>Pangkat TMT</td>
	<td>Golongan Ruang</td>
	<td>2011</td>
	<td>2012</td>
	<td>2013</td>
	<td>2014</td>
	<td>2015</td>
	<td>2016</td>
	<td>2017</td>
</tr>
</thead>
<tbody>
<?php foreach($result as $r): ?>
<tr>
	<td><?php echo $r["no"] ?></td>
	<td><?php echo $r["nama"] ?><br/><?php echo $r["nip"] ?></td>
	<td><?php echo $r["tmt_pangkat"] ?></td>
	<td><?php echo $r["golongan_ruang"] ?></td>
	<td><?php echo $r["2011"] ?></td>
	<td><?php echo $r["2012"] ?></td>
	<td><?php echo $r["2013"] ?></td>
	<td><?php echo $r["2014"] ?></td>
	<td><?php echo $r["2015"] ?></td>
	<td><?php echo $r["2016"] ?></td>
	<td><?php echo $r["2017"] ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</body>
</html>