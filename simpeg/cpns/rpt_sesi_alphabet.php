<?php 
include "../library/format.php";
include "db.php";

$format = new Format;

function get_data($tgl, $sesi){	
	switch ($sesi) {
	  case 1:
	    $sesi = "Sesi I";
	    break;
	  case 2:
	    $sesi = "Sesi II";
	    break;
	  case 3:
	    $sesi = "Sesi III";
	    break;
	  default:	 
	  	$sesi = "Sesi IV";
	}

	$q = mysql_query("select j.tanggal, j.sesi, ms.nik, register, no_peserta, nama, pen, s.Waktu 
			from jadwal_peserta j 
			inner join ms on ms.nik = j.nik
			inner join sesi_cat s on s.Sesi = j.sesi 
			where tanggal = '2014-10-$tgl' and j.sesi = '$sesi'
			order by nama ASC, tanggal, sesi, no_peserta");
	
	while($r = mysql_fetch_object($q)){
		$data[] = $r;
	}
	return $data;
}
?>

<html>
<head>
	<title>Jadwal Pelaksanaan CAT</title>
	<link href="../assets/bootstrap/css/bootstrap.css" rel="stylesheet">
	<script src="../assets/bootstrap/js/bootstrap.js"></script>
	<STYLE TYPE="text/css">
		H2 {page-break-before: always}
	</STYLE>
</head>
<body>
<?php for($tgl=13;$tgl<=15;$tgl++): ?>
	<?php for($sesi=1;$sesi<=4;$sesi++): ?>
		<?php $data =  get_data($tgl, $sesi); ?>				
		<h2 class="text-center">
			JADWAL PELAKSANAAN CAT CPNS KOTA BOGOR TAHUN 2014
		</h2>
		<table class="col-md-6">
			<tr>
				<td>Hari</td>
				<td>:</td>
				<td><?php echo $format->hari($format->date_dmY($data[0]->tanggal,"D")).", ".$format->date_dmY($data[0]->tanggal,"d F Y"); ?></td>
			</tr>
			<tr>
				<td>Waktu</td>
				<td>:</td>
				<td><?php echo $data[0]->Waktu." (".$data[0]->sesi.")" ?></td>
			</tr>
			<tr>
				<td>Lokasi</td>
				<td>:</td>
				<td>SMKN 3 Kota Bogor</td>
			</tr>
		</table>
		<br>
		<table class="table table-bordered">
		<thead>
			<th>NO</th>
			<th>NIK</th>
			
			<th>NO PESERTA</th>
			<th>NAMA</th>
			<th>JENJANG PENDIDIKAN</th>
		</thead>
		<tbody>			
			<?php $i = 1;?>
			<?php foreach($data as $p) :?>
			<tr>
				<td><?php echo $i++; ?></td>
				<td><?php echo $format->hari($format->date_dmY($data[0]->tanggal,"D")).' - '.$data[0]->Waktu." (".$data[0]->sesi.")" ?></td>
				
				<td><?php echo $p->no_peserta; ?></td>
				<td><?php echo strtoupper($p->nama); ?></td>
				<td><?php echo $p->pen; ?></td>
			</tr>
			<?php endforeach; ?>	
		</tbody>
		</table>
	<?php endfor; ?>
<?php endfor; ?>
</body>
</html>
