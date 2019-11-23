<?php require_once("konek.php"); ?>

<?php
mysqli_query($mysqli,"delete from buffer_kelengkapan_berkas");
$qu=mysqli_query($mysqli,"select id_unit_kerja from current_lokasi_kerja");
$unit = mysqli_fetch_array($qu);
?>
	
<?php

$qo=mysqli_query($mysqli,"select nama,pangkat_gol,nip_baru,pegawai.id_pegawai,nama_baru, current_lokasi_kerja.id_unit_kerja 
			     from pegawai 
				 inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai 
				 inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja 
				 where flag_pensiun=0 order by pangkat_gol desc ");
				 //where unit_kerja.id_skpd=$unit[0] and flag_pensiun=0 order by pangkat_gol desc ");
//echo("select nama,pangkat_gol,nip_baru from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where id_unit_kerja=$unit[0] order by nama");

mysqli_query($mysqli,"truncate buffer_kelengkapan_berkas");

echo("<table cellpadding=5 cellspacing=0 border=0><tr bgcolor=#cccccc><td class=bodas>No</td><td class=bodas>Nama </td><td class=bodas>NIP </td><td class=bodas> Golongan </td><td class=bodas> Unit Kerja </td><td class=bodas> SK CPNS </td><td class=bodas> SK PNS </td><td class=bodas> SK KP </td><td class=bodas> SK KGB </td><td class=bodas> Karpeg </td></tr>");
$r=1;
while($bata=mysqli_fetch_array($qo))
{
	set_time_limit(0);
	// -------------------- DATA SK  ------------------ //
	// CEK CPNS	
		$rsCpns = mysqli_query($mysqli,"SELECT id_berkas 
							   FROM sk s 
							   WHERE s.id_pegawai = $bata[id_pegawai] 
							   	AND s.id_kategori_sk = 6
							   LIMIT 0,1");
							   
		$rCpns = mysqli_fetch_array($rsCpns);
												   			
		$fileName = "Berkas/".$bata[nip_baru]."-".$rCpns[id_berkas]."-*.jpg";
		
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
							   WHERE s.id_pegawai = $bata[id_pegawai] 
							   	AND s.id_kategori_sk = 7
							   LIMIT 0,1");
							   
		$rPns = mysqli_fetch_array($rsPns);
												   			
		$fileName = "Berkas/".$bata[nip_baru]."-".$rPns[id_berkas]."-*.jpg";
		
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
							   WHERE s.id_pegawai = $bata[id_pegawai] 
							   	AND s.id_kategori_sk = 5 order by  tmt desc							   	
							   LIMIT 0,1 ");
							   
		$rKepang = mysqli_fetch_array($rsKepang);
												   			
		$fileName = "Berkas/".$bata[nip_baru]."-".$rKepang[id_berkas]."-*.jpg";
		
		$files = glob($fileName);
			
		$kepang = "";
		if(count($files) > 0)			
			$kepang = "1";
		else 
			$kepang = "";	
		// End of Cek Kenaikan pangkat terakhir
		
		// CEK Kenaikan Gaji Berkala Terakhir	
		$rsKgb = mysqli_query($mysqli,"SELECT id_berkas, tmt 
							   FROM sk s 
							   WHERE s.id_pegawai = $bata[id_pegawai] 
							   	AND s.id_kategori_sk = 9	
							   	ORDER BY tmt DESC						   	
							   LIMIT 0,1");
							   
		$rKgb = mysqli_fetch_array($rsKgb);
		$kgb = "";
										
		if(isset($rKgb[id_berkas]))
		{
			$fileName = "Berkas/".$bata[nip_baru]."-".$rKgb[id_berkas]."-*.jpg";
		
			$files = glob($fileName);
				
			
			if(count($files) > 0 && substr($rKgb[tmt], 0, 4) >= 2010)			
				$kgb = "1";
			else 
				$kgb = "";
		} 											   		
			
		// End of Cek Kenaikan Gaji Berkala terakhir
	
	// -------------------- END OF DATA SK ------------ //
	
	// CEK Kartu Pegawai
		$rsKarpeg = mysqli_query($mysqli,"SELECT id_berkas, id_kat 
							   FROM berkas s 
							   WHERE s.id_pegawai = $bata[id_pegawai] 
							   	AND s.id_kat = 10								   							   
							   LIMIT 0,1");
							   
		$rKarpeg = mysqli_fetch_array($rsKarpeg);
		$karpeg = "";
										
		if(isset($rKarpeg[id_berkas]))
		{
			$fileName = "Berkas/".$bata[nip_baru]."-".$rKarpeg[id_berkas]."-*.jpg";
		
			$files = glob($fileName);
				
			
			if(count($files) > 0 )			
				$karpeg = "1";
			else 
				$karpeg = "";
		} 											   		
			
		// End of Kartu Pegawai
	
	if($r%2==1)
	echo("<tr>");
	else
	echo("<tr bgcolor=#f0f0f0>");
echo("<td >$r</td><td><a draggable=true href=index2.php?x=box.php&od=$bata[3] id=$bata[id_pegawai] >$bata[0]</a> </td><td>$bata[2] </td><td> $bata[1] </td><td> $bata[4] </td>");



if($cpns)
	//echo "<td align=center>S</td>";
	echo "<td align=center>S</td>";
else
{ 
	$cpns = 0;
	echo "<td>&nbsp;</td>";
}
	
if($pns)
	echo "<td align=center>S</td>";
else 
{ 
	$pns = 0;
	echo "<td>&nbsp;</td>";
}
	
if($kepang)
	echo "<td align=center>S</td>";
else 
{ 
	$kepang = 0;
	echo "<td>&nbsp;</td>";
}

if($kgb)
	echo "<td align=center>S</td>";
else 
{ 
	$kgb = 0;
	echo "<td>&nbsp;</td>";
}

if($karpeg)
	echo "<td align=center>S</td>";
else 
{ 
	$karpeg = 0;
	echo "<td>&nbsp;</td>";
}

mysqli_query($mysqli,"insert into buffer_kelengkapan_berkas(id_pegawai, cpns, pns, kp, kgb, karpeg) VALUE('$bata[id_pegawai]','$cpns','$pns','$kepang','$kgb','$karpeg')");
	
$r++;

}
echo("</table>");



?>