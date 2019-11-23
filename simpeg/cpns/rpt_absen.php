<?php 
//header("Content-type: application/vnd-ms-excel");
//header("Content-Disposition: attachment; filename=absensi.xls");
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
			order by tanggal, sesi, no_peserta");
	
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
	<!--script src="../assets/bootstrap/js/bootstrap.js"></script-->
	<STYLE TYPE="text/css">
		h2{
			font-size: 14px;
			page-break-before: always;
		}
		th{
			font-size: 12px !important;
		}	
		td{
			font-size: 10px !important;
		}
		
		
		.table-bordered th,
		.table-bordered td {
			border: 1px solid #000 !important;
		 }
		 .table-bordered {
			border: 1px solid #000;
		}
		.table-bordered > thead > tr > th,
		.table-bordered > tbody > tr > th,
		.table-bordered > tfoot > tr > th,
		.table-bordered > thead > tr > td,
		.table-bordered > tbody > tr > td,
		.table-bordered > tfoot > tr > td {
		  border: 1px solid #000;
		}
		
		
	</STYLE>
</head>
<body>
<?php for($tgl=13;$tgl<=15;$tgl++): ?>
	<?php for($sesi=1;$sesi<=4;$sesi++): ?>
		<?php $data =  get_data($tgl, $sesi); ?>				
		<h2 class="text-center">
			DAFTAR HADIR <br>PELAKSANAAN CAT CPNS KOTA BOGOR TAHUN 2014
		</h2>
		<table width="100%">
			<tr>
				<td width="10%">Hari</td>
				<td width="2%">:</td>
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
		<thead class="text-center">
			<tr class="text-center">
				<td><strong>NO</strong></td>
				<td><strong>NIK</strong></td>			
				<td><strong>NO PESERTA</strong></td>
				<td><strong>NAMA</strong></th>
				<td  colspan="2"><strong>TANDA TANGAN</strong></td>
			</tr>
		</thead>
		<tbody>			
			<?php $i = 1;?>
			<?php foreach($data as $p) :?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $p->nik; ?></td>				
				<td><?php echo $p->no_peserta; ?></td>
				<td><?php echo strtoupper($p->nama); ?></td>
				<?php
					if($i%2 == 0){
						$is_odd = true;
						$align = "text-center";
					}else{
						$is_odd = false;
						$align = "text-left";
					}
				?>
				
				<td width="40%" class="<?php echo $align ?>"><?php echo $i; $i++?></td>
			</tr>
			<?php endforeach; ?>	
		</tbody>
		</table>
	<?php endfor; ?>
<?php endfor; ?>
</body>
</html>
