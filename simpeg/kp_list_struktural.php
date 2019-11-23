
<html>
	<head>
		<title>KP Oktober 2012</title>
	</head>
<body>
<?php 
include "konek.php";
include "kp_navbar.php";
$whereSkpd = "";
if(isset($ata[id_pegawai]) && !$_REQUEST[all])
{
	$qu = mysqli_query($mysqli,"select id_unit_kerja from current_lokasi_kerja where id_pegawai=$ata[id_pegawai]");
	$unit = mysqli_fetch_array($qu);
	
	$qSkpd = mysqli_query($mysqli,"SELECT id_skpd FROM unit_kerja WHERE id_unit_kerja = $unit[0]");
	$skpd = mysqli_fetch_array($qSkpd);
	
	$whereSkpd = $skpd[0];
}

$q = "SELECT p.nama, p.nip_baru, p.pangkat_gol, s.id_pegawai, s.tmt, s.keterangan, u.nama_baru, u.id_skpd,p.id_j
FROM sk s INNER JOIN
(
SELECT id_pegawai, MAX(tmt) as TMT
FROM sk s
WHERE id_kategori_sk = 5
GROUP BY id_pegawai
) as t ON s.id_pegawai = t.id_pegawai AND t.TMT = s.tmt
INNER JOIN pegawai p ON s.id_pegawai = p.id_pegawai
INNER JOIN current_lokasi_kerja c ON p.id_pegawai = c.id_pegawai 
INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
WHERE s.tmt = '2008-10-01' AND p.jenjab LIKE 'struktural' AND p.flag_pensiun = 0 and p.id_j>0 ";

if($whereSkpd != "")
{
	$q = $q." AND u.id_skpd = $whereSkpd ";
}

if($_REQUEST['staff'])
{
	$q = $q." AND (p.id_j = 0 OR p.id_j IS NULL) ";
}

$q = $q."GROUP BY s.id_pegawai
ORDER BY u.nama_baru ASC, p.nama";

//echo $q;
$rs = mysqli_query($mysqli,$q);
$counter = 1;
?>
<div class="page-header">
	<h1>Nominatif KP <br/>
	<small>Daftar pegawai yang berhak mengajukan kenaikan pangkat untuk periode Oktober 2012</small></h1>
</div>
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<td>NO</td>
			<td>Nama</td>
			<td>NIP</td>
			<td>Golongan Saat Ini</td>
            <td>Eselon</td>
			<td>SKPD</td>
			<td>SK Pangkat Terakhir</td>
		</tr>
	</thead>
	<tbody>
		<?php while($r = mysqli_fetch_array($rs)): ?>
		<?php
		// CEK Kenaikan Pangkat Terakhir	
		$rsKepang = mysqli_query($mysqli,"SELECT id_berkas 
							   FROM sk s 
							   WHERE s.id_pegawai = $r[id_pegawai] 
							   	AND s.id_kategori_sk = 5							   	
							   LIMIT 0,1");
							   
		$rKepang = mysqli_fetch_array($rsKepang);
												   			
		$fileName = "Berkas/".$r[nip_baru]."-".$rKepang[id_berkas]."-*.jpg";
		
		$files = glob($fileName);
			
		$kepang = "";
		if(count($files) > 0)			
			$kepang = "1";
		else 
			$kepang = "";	
		// End of Cek Kenaikan pangkat terakhir
		?>
		<tr>
			<td><?php echo $counter; ?></td>
			<td><a href="../admin/dock2.php?id=<?php echo $r[id_pegawai]; ?>" target="_blank" ><?php echo $r[nama]; ?></a></td>
			<td><?php echo $r[nip_baru]; ?></td>
			<td><?php echo $r[pangkat_gol]; ?></td>
            <td><?php 
			if($r[8]>0)
			{
				$qj=mysqli_query($mysqli,"select eselon from jabatan where id_j=$r[8]");
				$jab=mysqli_fetch_array($qj);
				echo("$jab[0]");
//				echo("select eseleon from jabatan where id_j=$r[8]");
			}
			else
			echo("staff");
			 ?></td>
			<td><?php echo $r[nama_baru]; ?></td>
			<td>
				<?php if($kepang): ?>
					<span class="label label-success">Lengkap</span>
				<?php else: ?>
					<span class="label label-important">Tidak Ada</span>
				<?php endif;?>
			</td>
		</tr>
		<?php $counter++ ?>
		<?php endwhile; ?>
	</tbody>
</table>

</body>
</html>