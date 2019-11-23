<?
	include "konek.php";
?>

<h2>
	KELENGKAPAN DATA PEGAWAI
</h2>

<table border="1">
	<tr>
		<td>No</td>
		<td>Nama</td>
		<td>NIP</td>
		<td>Golongan</td>
		
		<td>SK CPNS</td>
		<td>SK PNS</td>
		<td>SK<br/>Pangkat <br/>Terakhir</td>
		<td>Karpeg</td>
		<td>DP3 1</td>
		<td>DP3 2</td>
		<td>SKPD</td>
	</tr>
	
	<?php
	$rs = mysqli_query($mysqli,"SELECT ae.id_pegawai, ae.nama, ae.nip_baru, ae.pangkat_gol, ae.nama_baru
					   FROM active_employees ae						   					   			 
					   ORDER BY nama_baru, nama");
					   							 
	$i = 1;
	while($r = mysqli_fetch_array($rs))
	{
		// CEK CPNS	
		$rsCpns = mysqli_query($mysqli,"SELECT id_berkas 
							   FROM sk s 
							   WHERE s.id_pegawai = $r[id_pegawai] 
							   	AND s.id_kategori_sk = 6
							   LIMIT 0,1");
							   
		$rCpns = mysqli_fetch_array($rsCpns);
												   			
		$fileName = "Berkas/".$r[nip_baru]."-".$rCpns[id_berkas]."-*.jpg";
		
		$files = glob($fileName);
			
		$cpns = "";
		if(count($files) > 0)			
			$cpns = "1";
		else 
			$cpns = "";	
		// End of Cek CPNS
		
		// CEK PNS	
		$rsPns = mysqli_query($mysqli,"SELECT id_berkas 
							   FROM sk s 
							   WHERE s.id_pegawai = $r[id_pegawai] 
							   	AND s.id_kategori_sk = 7
							   LIMIT 0,1");
							   
		$rPns = mysqli_fetch_array($rsPns);
												   			
		$fileName = "Berkas/".$r[nip_baru]."-".$rPns[id_berkas]."-*.jpg";
		
		$files = glob($fileName);
			
		$pns = "";
		if(count($files) > 0)			
			$pns = "1";
		else 
			$pns = "";	
		// End of Cek CPNS
		
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
		
		// CEK kartu pegawai	
		$rsKarpeg = mysqli_query($mysqli,"SELECT id_berkas 
							   FROM berkas b 
							   WHERE b.id_pegawai = $r[id_pegawai] 
							   	AND b.nm_berkas LIKE 'Kartu Pegawai'							   	
							   LIMIT 0,1");
							   
		$rKarpeg = mysqli_fetch_array($rsKarpeg);
												   			
		$fileName = "Berkas/".$r[nip_baru]."-".$rKarpeg[id_berkas]."-*.jpg";
		
		$files = glob($fileName);
			
		$karpeg = "";
		if(count($files) > 0)			
			$karpeg = "1";
		else 
			$karpeg = "";	
		// End of kartu pegawai		
		
		?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $r[nama]; ?></td>
			<td><?php echo $r[nip_baru]; ?></td>
			<td><?php echo $r[pangkat_gol]; ?></td>
			
			<td <?php if($cpns) echo "style='background-color: grey;'"?>><?php echo $cpns; ?></td>
			<td <?php if($pns) echo "style='background-color: grey;'"?>><?php echo $pns; ?></td>
			<td <?php if($kepang) echo "style='background-color: grey;'"?>><?php echo $kepang; ?></td>
			<td <?php if($karpeg) echo "style='background-color: grey;'"?>><?php echo $karpeg; ?></td>
			<td <?php if($dp31) echo "style='background-color: grey;'"?>><?php echo $dp31; ?></td>
			<td <?php if($dp32) echo "style='background-color: grey;'"?>><?php echo $dp32; ?></td>
			<td><?php echo $r[nama_baru]; ?></td>
		</tr>
		<?php
		$i++;
	}					
	?>
	
</table>