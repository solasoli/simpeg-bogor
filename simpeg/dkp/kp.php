<?php include_once "lib/kp.php"; ?>
<html>
<head>
	<title>Kenaikan Pangkat</title>
</head>
<body>
<h1>PENJAGAAN KENAIKAN PANGKAT <br/> Dinas Kebersihan dan Pertamanan Kota Bogor</h1>
<table border="1" width="100%">
<thead>
<tr>
	<td rowspan="2">No</td>
	<td rowspan="2">Nama/NIP<br/>Tempat Tgl. Lahir</td>
	<td rowspan="2">Pangkat/Gol<br/>Pendidikan TMT</td>
	<td rowspan="2">Jabatan</td>
	<td colspan="2">2011</td>
	<td colspan="2">2012</td>
	<td colspan="2">2013</td>
	<td colspan="2">2014</td>
	<td colspan="2">2015</td>
	<td colspan="2">2016</td>
	<td colspan="2">2017</td>
</tr>
<tr>
	<td>April</td>
	<td>Oktober</td>
	<td>April</td>
	<td>Oktober</td>
	<td>April</td>
	<td>Oktober</td>
	<td>April</td>
	<td>Oktober</td>
	<td>April</td>
	<td>Oktober</td>
	<td>April</td>
	<td>Oktober</td>
	<td>April</td>
	<td>Oktober</td>
</tr>
</thead>
<tbody>
<?php foreach($result as $r): ?>
<tr>
	<td><?php echo $r["no"] ?></td>
	<td>
		<?php echo $r["nama"] ?> <br/> 
		<?php echo $r["nip"] ?> <br/>
		<?php echo $r["ttl"] ?>
	</td>
	<td>
		<?php echo $r["pangkat"]." - ".$r["gol"]; ?><br/>
		<?php echo $r["pendidikan"] ?><br/>
		<?php echo $r["tmt_pangkat"] ?>
	</td>
	<td><?php echo $r["jabatan"] ?></td>
	<td><?php echo $r["201104"] ?></td>
	<td><?php echo $r["201110"] ?></td>
	<td><?php echo $r["201204"] ?></td>
	<td><?php echo $r["201210"] ?></td>
	<td><?php echo $r["201304"] ?></td>
	<td><?php echo $r["201310"] ?></td>
	<td><?php echo $r["201404"] ?></td>
	<td><?php echo $r["201410"] ?></td>
	<td><?php echo $r["201504"] ?></td>
	<td><?php echo $r["201510"] ?></td>
	<td><?php echo $r["201604"] ?></td>
	<td><?php echo $r["201610"] ?></td>
	<td><?php echo $r["201704"] ?></td>
	<td><?php echo $r["201710"] ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</body>
</html>