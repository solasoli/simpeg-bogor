<html>
<head>
<title>Laporan Jumlah Transit Kendaraan Umum</title>

<style>
table, tr, td, thead, th{
	border: black solid 1px;
	border-collapse: collapse;
	padding: 5px;
	font-size: 10pt;
}
h1{
	font-size: 14pt;
	text-align: center;
}
</style>

</head>
<body>
<h1>LAPORAN JUMLAH TRANSIT KENDARAAN UMUM PNS KOTA BOGOR</h1>
<table id="pegawai">
<thead>
	<th>No.</th>
	<th>Nama</th>
	<th>NIP</th>
	<th>Unit Kerja</th>
	<th>Alamat</th>	
	<th>Jumlah Transit</th>
</thead>
<tbody>
<?php $i = 1 ?>
<?php foreach($pegawai as $p): ?>
<tr>
	<td><? echo $i++; ?></td>
	<td><? echo $p->nama; ?></td>
	<td><? echo $p->nip_baru; ?></td>
	<td><? echo $p->nama_baru; ?></td>
	<td><? echo $p->alamat; ?></td>	
	<td><? echo $p->jumlah_transit; ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</body>
</html>